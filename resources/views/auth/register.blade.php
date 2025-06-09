<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Assuming you are using Tailwind via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <title>Daftar Akun - Athaya Shop</title>
</head>
<body class="bg-gray-100 overflow-hidden">
<div class="flex flex-col md:flex-row h-screen">
    <!-- Left Side: Registration Form -->
    <div class="w-full md:w-1/2 bg-white flex flex-col justify-center items-center p-6 md:p-10 order-last md:order-first overflow-y-auto">
        <div class="w-full max-w-sm">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Daftar Akun</h2>
            <p class="text-gray-600 mb-8">Silahkan buat akun untuk masuk ke dalam sistem.</p>

            <!-- Registration Form -->
            <form action="{{ route('register.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="user@email.com" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" id="password" name="password" placeholder="Min. 8 karakter" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" class="w-full mt-1 p-3 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($roles as $role)
                            <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Daftar Akun
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-primary hover:underline font-semibold">Masuk di sini</a>
            </p>
        </div>
    </div>

    <!-- Right Side: Image background (Hidden on mobile) -->
    <div class="hidden md:block md:w-1/2">
        <img src="https://placehold.co/1080x1920/e2e8f0/4a5568?text=Athaya+Shop"
             alt="Decorative image for Athaya Shop registration page"
             class="w-full h-full object-cover"
             onerror="this.onerror=null;this.src='https://placehold.co/1080/e2e8f0/4a5568?text=Image+Not+Found';">
    </div>
</div>
</body>
</html>
