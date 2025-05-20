<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = false; // Ubah ke true kalau sudah live
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(array $params)
    {
        return Snap::createTransaction($params);
    }

    public function getTransactionStatus(string $orderId)
    {
        return \Midtrans\Transaction::status($orderId);
    }
}
