@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 md:p-8">

        {{-- Judul Halaman dan Tombol Cetak --}}
        {{-- 'print:hidden' akan menyembunyikan seluruh div ini saat mencetak --}}
        <div class="text-center mb-8 print:hidden">
            <h1 class="text-3xl font-bold text-gray-800">Profil Pengguna</h1>
            <p class="text-gray-600 mt-2">Di bawah ini adalah kartu identitas digital Anda.</p>
            <button onclick="window.print()" class="mt-4 px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                🖨️ Cetak Kartu ID
            </button>
        </div>

        {{-- KARTU ID --}}
        {{-- Elemen ini TIDAK memiliki 'print:hidden', jadi akan terlihat saat mencetak --}}
        {{-- Class 'print:*' akan diterapkan HANYA saat mencetak --}}
        <div id="id-card" class="max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 border border-gray-200
                           print:shadow-none print:border-2 print:max-w-full print:m-0">

            <div class="flex justify-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Kartu Tanda Pengenal</h2>
            </div>

            <hr>

            <div class="flex items-center mt-4">
                {{-- Detail Pengguna --}}
                <div class="ml-6">
                    <div class="uppercase tracking-wide text-sm text-blue-500 font-semibold">{{ $user->role }}</div>
                    <p class="block mt-1 text-lg leading-tight font-medium text-black">{{ $user->name }}</p>
                </div>
            </div>

            <div class="mt-6 text-center">
                <h3 class="text-md font-bold mb-2">QR Code Absensi</h3>
                {{-- Tampilkan QR Code SVG --}}
                <div class="inline-block p-2 bg-white border">
                    {!! $qrCodeSvg !!}
                </div>
                <p class="mt-2 text-xs text-gray-500">Pindai kode ini pada mesin absensi.</p>
            </div>
        </div>

        {{-- Teks Bantuan di Bagian Bawah Halaman --}}
        {{-- 'print:hidden' juga digunakan di sini --}}
        <div class="text-center mt-6 text-sm text-gray-500 print:hidden">
            <p>Anda dapat mencetak kartu ini untuk kemudahan saat melakukan absensi.</p>
        </div>

    </div>
@endsection
