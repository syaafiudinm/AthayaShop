@extends('layouts.app')

@section('content')
<div class="flex-1 p-8">
        <h2 class="text-3xl font-semibold mb-4 text-center">Scan QR Code untuk Absensi</h2>
        <div class="w-full max-w-2xl mx-auto">
            <div id="reader" style=""></div>
        </div>
    <div id="result" style="text-align: center"></div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Kirim token ke backend verifikasi
         const token = decodedText.split('/').pop();

        fetch(`/absen/verify/${encodeURIComponent(token)}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('result').textContent = data.message;
                document.getElementById('result').classList.remove('hidden');
                document.getElementById('result').classList.add('text-green-600', 'font-semibold');

                html5QrcodeScanner.clear();

                // 🚀 Delay 5 detik lalu redirect
                setTimeout(() => {
                    window.location.href = "/absen"; // <-- ganti dengan route tujuan lo
                }, 5000);
            })
            .catch(() => {
                document.getElementById('result').textContent = 'Gagal verifikasi QR Code.';
                document.getElementById('result').classList.remove('hidden');
                document.getElementById('result').classList.add('text-red-600');
            });
        // Stop scanning setelah dapat hasil
        html5QrcodeScanner.clear();
    }
    var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection
