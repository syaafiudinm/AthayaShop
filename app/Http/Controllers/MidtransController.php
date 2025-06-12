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
        // Log setiap notifikasi yang masuk untuk mempermudah pelacakan
        Log::info('Midtrans notification received.', ['payload' => $request->all()]);

        try {
            $payload = $request->all();
            $serverKey = env('MIDTRANS_SERVER_KEY');

            if (!$serverKey) {
                Log::error('MIDTRANS_SERVER_KEY is not set in .env file.');
                return response('Server key not configured', 500);
            }

            // Verifikasi signature key
            $orderId = $payload['order_id'];
            $statusCode = $payload['status_code'];
            $grossAmount = $payload['gross_amount'];
            $signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

            if ($signature !== $payload['signature_key']) {
                Log::warning('Invalid Midtrans signature key.', ['order_id' => $orderId]);
                return response('Invalid signature', 403);
            }

            // Cari transaksi berdasarkan order_id
            $sale = Sale::with('items')->where('order_id', $orderId)->first();

            if (!$sale) {
                Log::warning('Sale not found in database.', ['order_id' => $orderId]);
                return response('Order not found', 404);
            }

            // Hindari proses duplikat jika notifikasi sudah pernah diproses
            if ($sale->status !== 'pending') {
                Log::info('Notification for this order has already been processed.', ['order_id' => $orderId, 'status' => $sale->status]);
                return response('Notification for this order has already been processed', 200);
            }

            $transactionStatus = $payload['transaction_status'];

            DB::transaction(function () use ($sale, $transactionStatus) {
                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    // Update status pembayaran
                    $sale->update(['status' => 'paid']);

                    // Kurangi stok produk dengan aman
                    foreach ($sale->items as $item) {
                        $product = Product::lockForUpdate()->find($item->product_id);

                        // --- PERBAIKAN UTAMA ADA DI SINI ---
                        // Selalu periksa apakah produk ditemukan sebelum melakukan operasi
                        if ($product) {
                            $product->decrement('stock', $item->total);
                        } else {
                            // Beri peringatan di log jika produk tidak ada,
                            // tapi jangan hentikan seluruh transaksi.
                            Log::warning('Product not found for stock reduction.', [
                                'product_id' => $item->product_id,
                                'order_id' => $sale->order_id
                            ]);
                        }
                    }
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    $sale->update(['status' => 'failed']);
                }
            });

            Log::info('Notification processed successfully.', ['order_id' => $orderId]);
            return response('OK', 200);

        } catch (\Exception $e) {
            // Log error yang sebenarnya terjadi
            Log::error('Midtrans notification processing failed.', [
                'order_id' => $request->input('order_id'),
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString() // Ini akan memberi Anda detail lengkap error
            ]);
            return response('Error processing notification', 500);
        }
    }
}
