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
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $orderId = $notif->order_id;  // misal: ATHAYA-123-1685000000
        $saleId = explode('-', $orderId)[1]; // ambil id sale: 123

        $sale = Sale::with('items')->find($saleId);

        if (!$sale) {
            return response('Order not found', 404);
        }

        if (in_array($transaction, ['capture', 'settlement'])) {
            // Pembayaran berhasil
            $sale->update(['status' => 'paid']);

            // Kurangi stok
            foreach ($sale->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->total);
                }
            }
        } elseif (in_array($transaction, ['cancel', 'deny', 'expire'])) {
            // Pembayaran gagal/batal
            $sale->update(['status' => 'failed']);
        }

        return response('OK', 200);
    }
}
