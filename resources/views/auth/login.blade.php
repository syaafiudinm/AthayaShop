<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

    </style>
    <title>Athaya Shop</title>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Left Side: Login Form -->
        <div class="w-1/2 bg-white flex flex-col justify-center items-center p-10">
            <h2 class="text-4xl font-bold text-gray-800 mb-8">Selamat Datang</h2>
            <p class="text-lg text-gray-600 mb-6">Silahkan login untuk masuk ke dalam sistem</p>

            @include('components.alert')

            <!-- Login Form -->
            <form action="{{route('authenticate')}}" method="POST" class="w-full max-w-sm">
                @csrf
                <div class="mb-6">
                    <label for="email" class="block text-sm text-gray-700">Email</label>
                    <input type="email" id="email" name="email" placeholder="user@email.com" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-sm text-gray-700">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Min. 8 karakter" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full border-2 border-black bg-primary text-white py-3 rounded-lg mb-4 hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">Masuk</button>
            </form>
            <span>Belum punya akun?
                <a href="{{ route('register') }}" class="text-primaray hover:underline font-semibold">Daftar!</a>
            </span>
        </div>

        <!-- Right Side: Empty or Background -->
        <div class="w-1/2 bg-gray-200 flex justify-center items-center">

        </div>
    </div>
</body>
