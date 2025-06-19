<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Pending</title>
    <meta http-equiv="refresh" content="5;url={{ route('products') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-yellow-50 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-lg rounded-lg p-8 text-center max-w-md">
    <svg class="mx-auto mb-4 w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
    </svg>
    <h2 class="text-2xl font-bold text-yellow-600 mb-2">Pembayaran Belum Selesai</h2>
    <p class="text-gray-600 mb-4">Transaksi Anda belum diselesaikan. Silakan cek kembali metode pembayaran Anda.</p>
    <p class="text-sm text-gray-400">Anda akan diarahkan kembali dalam 5 detik...</p>
    <a href="{{ route('products') }}" class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
        Kembali ke Produk Sekarang
    </a>
</div>

</body>
</html>
