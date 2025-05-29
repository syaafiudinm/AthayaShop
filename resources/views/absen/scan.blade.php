@extends('layouts.app')

@section('content')
<div class="flex-1 p-8">
        <h2 class="text-3xl font-semibold mb-4 text-center">Scan QR Code untuk Absensi</h2>
        <div class="w-full max-w-2xl mx-auto">
            <div id="reader" style=""></div>
        </div>
    <div id="result" style="text-align: center"></div>
    <hr class="my-8">
    <h3 class="text-2xl font-semibold my-8 text-center">Izin & Sakit</h3>
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mt-6">
    <form action="{{ route('absen.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Upload Dokumen Pendukung</h2>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Jenis Ketidakhadiran</label>
                <select name="status" id="status"
                        class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 p-2"
                        required>
                    <option value="" disabled selected>Pilih status</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Izin">Izin</option>
                </select>
            </div>
        <div>
            <label for="dokumen" class="block text-sm font-medium text-gray-700 mb-1">
                Upload Dokumen (PDF/JPG/PNG)
            </label>
            <input type="file" name="dokumen" accept=".pdf,.jpg,.jpeg,.png"
                   class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                          file:rounded-lg file:border-0
                          file:text-sm file:font-semibold
                          file:bg-blue-50 file:text-blue-700
                          hover:file:bg-blue-100">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-blue-700 transition">
            Absen Sekarang
        </button>
    </form>
</div>

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
