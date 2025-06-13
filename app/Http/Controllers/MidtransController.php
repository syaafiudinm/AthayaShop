<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Sale;
use App\Models\Product;
use Exception;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        // Terima request JSON
        $payload = $request->json()->all();
        $orderId = $payload['order_id'] ?? 'N/A';

        Log::info('Midtrans notification received.', ['payload' => $payload]);

        try {
            $serverKey = env('MIDTRANS_SERVER_KEY');

            if (!$serverKey) {
                Log::error('MIDTRANS_SERVER_KEY is not set.', ['order_id' => $orderId]);
                return response('Server key not configured', 500);
            }

            // Gunakan string original dari payload
            $expectedSignature = hash('sha512',
                $payload['order_id'] .
                $payload['status_code'] .
                $payload['gross_amount'] .
                $serverKey
            );

            if ($expectedSignature !== $payload['signature_key']) {
                Log::warning('Invalid Midtrans signature.', [
                    'order_id' => $orderId,
                    'expected' => $expectedSignature,
                    'received' => $payload['signature_key'],
                ]);
                return response('Invalid signature', 403);
            }

            $sale = Sale::with('items')->where('order_id', $payload['order_id'])->first();
            if (!$sale) {
                Log::warning('Sale not found.', ['order_id' => $orderId]);
                return response('Order not found', 404);
            }

            if ($sale->status !== 'pending') {
                return response('Notification already processed', 200);
            }

            $transactionStatus = $payload['transaction_status'];

            if (in_array($transactionStatus, ['settlement', 'capture'])) {
                $this->handleSuccessfulPayment($sale);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $sale->update(['status' => 'failed']);
                Log::info('Transaction marked as failed.', ['order_id' => $orderId, 'status' => $transactionStatus]);
            }

            Log::info('Notification processed successfully.', ['order_id' => $orderId]);
            return response('OK', 200);

        } catch (Exception $e) {
            Log::error('Midtrans notification processing failed.', [
                'order_id' => $orderId,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response('Error processing notification', 500);
        }
    }

    protected function handleSuccessfulPayment(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            $sale->update(['status' => 'paid']);

            foreach ($sale->items as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);

                if (!$product) {
                    throw new Exception("Product not found: ID {$item->product_id}");
                }

                if ($product->stock < $item->total) {
                    throw new Exception("Insufficient stock for product ID: {$product->id}");
                }

                $product->decrement('stock', $item->total);
            }
        });

        Log::info('Payment processed and stock updated.', ['order_id' => $sale->order_id]);
    }
}
