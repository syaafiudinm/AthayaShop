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
        $payload = $request->all();
        $serverKey = env('MIDTRANS_SERVER_KEY');

        // Verifikasi signature key
        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $payload['signature_key']) {
            return response('Invalid signature', 403);
        }

        // Cari transaksi berdasarkan order_id
        $sale = Sale::with('items')->where('order_id', $orderId)->first();

        if (!$sale) {
            return response('Order not found', 404);
        }

        // Hindari proses duplikat
        if ($sale->status !== 'pending') {
            return response('Notification for this order has already been processed', 200);
        }

        $transactionStatus = $payload['transaction_status'];

        try {
            DB::transaction(function () use ($sale, $transactionStatus) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    // Update status pembayaran menjadi 'paid' atau 'success'
                    $sale->update(['status' => 'paid']);

                    // Kurangi stok produk
                    foreach ($sale->items as $item) {
                        Product::lockForUpdate()->find($item->product_id)->decrement('stock', $item->total);
                    }
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    $sale->update(['status' => 'failed']);
                }
            });
        } catch (\Exception $e) {
            return response('Error processing notification: ' . $e->getMessage(), 500);
        }

        return response('OK', 200);
    }
}
