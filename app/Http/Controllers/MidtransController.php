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

        $serverKey = config('services.midtrans.server_key', env('MIDTRANS_SERVER_KEY'));
        if (!$serverKey) {
            return response('Midtrans server key not configured', 500);
        }


        $orderId = $payload['order_id'];
        $statusCode = $payload['status_code'];
        $grossAmount = $payload['gross_amount'];
        $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $payload['signature_key']) {

            return response('Invalid signature', 403);
        }

        $sale = Sale::with('items')->where('order_id', $orderId)->first();

        if (!$sale) {
            return response('Order not found', 404);
        }

        // Jangan proses notifikasi jika statusnya sudah final (paid/success atau failed)
        if (in_array($sale->status, ['paid', 'success', 'failed'])) {
            return response('Notification for this order has already been processed', 200);
        }

        // 5. Update status dan kurangi stok dalam satu transaksi database
        $transactionStatus = $payload['transaction_status'];

        try {
            DB::transaction(function () use ($sale, $transactionStatus) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    // Pembayaran berhasil
                    $sale->update(['status' => 'paid']); // Atau 'success'

                    // Kurangi stok produk
                    foreach ($sale->items as $item) {
                        // Menggunakan lockForUpdate() untuk mencegah race condition
                        $product = Product::lockForUpdate()->find($item->product_id);
                        if ($product) {
                            $product->decrement('stock', $item->total);
                        }
                    }
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    // Pembayaran gagal
                    $sale->update(['status' => 'failed']);
                }
            });
        } catch (\Exception $e) {
            // Jika terjadi error, kirim response error agar Midtrans mencoba lagi
            return response('Error processing notification: ' . $e->getMessage(), 500);
        }

        // 6. Kirim response OK ke Midtrans
        return response('OK', 200);
    }
}
