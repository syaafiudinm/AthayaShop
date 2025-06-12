<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Sale;
use App\Models\Product;

class MidtransController extends Controller
{
    public function notification(Request $request)
    {
        Log::info('Midtrans notification received.', ['payload' => $request->all()]);
        $orderId = $request->input('order_id', 'N/A');

        try {
            $payload = $request->all();
            $serverKey = env('MIDTRANS_SERVER_KEY');

            if (!$serverKey) {
                Log::error('MIDTRANS_SERVER_KEY is not set.', ['order_id' => $orderId]);
                return response('Server key not configured', 500);
            }

            // Verifikasi signature
            $signature = hash('sha512', $payload['order_id'] . $payload['status_code'] . $payload['gross_amount'] . $serverKey);
            if ($signature !== $payload['signature_key']) {
                Log::warning('Invalid Midtrans signature.', ['order_id' => $orderId]);
                return response('Invalid signature', 403);
            }

            $sale = Sale::with('items')->where('order_id', $orderId)->first();
            if (!$sale) {
                Log::warning('Sale not found.', ['order_id' => $orderId]);
                return response('Order not found', 404);
            }

            if ($sale->status !== 'pending') {
                return response('Notification already processed', 200);
            }

            $transactionStatus = $payload['transaction_status'];
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $this->handleSuccessfulPayment($sale);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $sale->update(['status' => 'failed']);
            }

            Log::info('Notification processed successfully.', ['order_id' => $orderId]);
            return response('OK', 200);

        } catch (Exception $e) {
            Log::error('Midtrans notification processing failed.', [
                'order_id' => $orderId,
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response('Error processing notification', 500);
        }
    }

    protected function handleSuccessfulPayment(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            // Update status penjualan terlebih dahulu
            $sale->update(['status' => 'paid']);

            // Proses setiap item secara terpisah dengan penanganan error sendiri
            foreach ($sale->items as $item) {
                try {
                    $product = Product::lockForUpdate()->find($item->product_id);

                    if (!$product) {
                        throw new Exception('Product not found with ID: ' . $item->product_id);
                    }

                    if ($product->stock < $item->total) {
                        throw new Exception('Insufficient stock for product ID: ' . $product->id);
                    }

                    $product->decrement('stock', $item->total);

                } catch (Exception $e) {
                    // Jika ada error pada satu item, log error tersebut dan batalkan seluruh transaksi
                    Log::error('Failed to process sale item.', [
                        'order_id' => $sale->order_id,
                        'sale_item_id' => $item->id,
                        'error' => $e->getMessage()
                    ]);
                    // Lempar kembali error untuk memicu rollback DB::transaction
                    throw $e;
                }
            }
        });
    }
}
