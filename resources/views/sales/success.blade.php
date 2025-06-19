<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaksi Berhasil</title>
    <meta http-equiv="refresh" content="5;url={{ route('products') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-lg rounded-lg p-8 text-center max-w-md">
    <svg class="mx-auto mb-4 w-16 h-16 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
    <h2 class="text-2xl font-bold text-green-600 mb-2">Pembayaran Berhasil</h2>
    <p class="text-gray-600 mb-4">Terima kasih! Transaksi Anda telah diproses.</p>
    <p class="text-sm text-gray-400">Anda akan diarahkan kembali dalam 5 detik...</p>
    <a href="{{ route('products') }}" class="mt-4 inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
        Kembali ke Produk Sekarang
    </a>
</div>

</body>
</html>
