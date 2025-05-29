@extends('layouts.app')

@section('content')
<div class="flex-1 p-8">
        <h2 class="text-3xl font-semibold mb-4 text-center">Scan QR Code untuk Absensi</h2>
        <div class="w-full max-w-2xl mx-auto">
            <div id="reader" style=""></div>
        </div>
    <div id="result" style="text-align: center"></div>
</div>

<form action="{{ route('absen.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow-md">
    @csrf

    <label for="status" class="block font-medium text-sm">Pilih Status:</label>
    <select name="status" id="status" class="input w-full">
        <option value="Sakit">Sakit</option>
        <option value="Izin">Izin</option>
    </select>

    <label for="dokumen" class="block font-medium text-sm">Upload Surat Keterangan:</label>
    <input type="file" name="dokumen" class="input w-full" accept=".jpg,.png,.pdf">

    <button type="submit" class="btn bg-blue-600 text-white">Kirim</button>
</form>

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
                document.getElementById('result').classList.add('text-blue-500', 'font-semibold');

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
