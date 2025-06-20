<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .btn {
            @apply bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded text-sm font-medium;
        }
        .input {
            @apply border border-gray-300 rounded px-3 py-2 text-sm;
        }

        #chartHadir, #chartSakit, #chartIzin {
            width: 100%; /* Ensure the chart container takes up the full width */
            height: auto; /* Ensure the chart height adjusts to its content */
        }

        /* --- Loading Overlay CSS --- */
        #loading-overlay {
            display: none; /* Hidden by default */
            justify-content: center;
            align-items: center;
            background-color: black;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            width: 100%;
            height: 100%;
            opacity: 0.75;
        }
    </style>
    <title>Athaya Shop</title>
    @livewireStyles
</head>
<body class="bg-gray-100">

<div id="loading-overlay">
    <div class="text-white text-2xl">
        <svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>

<div class="relative min-h-screen lg:flex">
    <div id="sidebar" class="w-64 bg-primary shadow-md px-4 py-8 text-white fixed inset-y-0 left-0 transform -translate-x-full transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 z-40">
        <div class="px-2">
            <h2 class="text-2xl font-bold text-white">ATHAYA SHOP</h2>
            <p class="mb-12 text-xs text-white">Dashboard System</p>
        </div>
        <ul class="space-y-8">
            <li>
                <a href="{{ route('beranda') }}" class="flex items-center gap-2 {{ request()->routeIs('beranda') ? 'text-black font-semibold bg-white p-2 rounded-md' : 'text-white' }}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.3335 15.8334V8.33335C3.3335 8.06947 3.39266 7.81947 3.511 7.58335C3.62933 7.34724 3.79239 7.1528 4.00016 7.00002L9.00016 3.25002C9.29183 3.0278 9.62516 2.91669 10.0002 2.91669C10.3752 2.91669 10.7085 3.0278 11.0002 3.25002L16.0002 7.00002C16.2085 7.1528 16.3718 7.34724 16.4902 7.58335C16.6085 7.81947 16.6674 8.06947 16.6668 8.33335V15.8334C16.6668 16.2917 16.5035 16.6842 16.1768 17.0109C15.8502 17.3375 15.4579 17.5006 15.0002 17.5H12.5002C12.2641 17.5 12.0663 17.42 11.9068 17.26C11.7474 17.1 11.6674 16.9022 11.6668 16.6667V12.5C11.6668 12.2639 11.5868 12.0661 11.4268 11.9067C11.2668 11.7472 11.0691 11.6672 10.8335 11.6667H9.16683C8.93072 11.6667 8.73294 11.7467 8.5735 11.9067C8.41405 12.0667 8.33405 12.2645 8.3335 12.5V16.6667C8.3335 16.9028 8.2535 17.1009 8.0935 17.2609C7.9335 17.4209 7.73572 17.5006 7.50016 17.5H5.00016C4.54183 17.5 4.14961 17.337 3.8235 17.0109C3.49738 16.6847 3.33405 16.2922 3.3335 15.8334Z" fill="{{ request()->routeIs('beranda') ? '#000000' : '#FFFFFF' }}" />
                    </svg>
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('kasir') }}" class="flex items-center gap-2 {{ request()->routeIs('kasir') ? 'text-black font-semibold bg-white p-2 rounded-md' : 'text-white' }}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.25 2.5H3.75C3.41848 2.5 3.10054 2.6317 2.86612 2.86612C2.6317 3.10054 2.5 3.41848 2.5 3.75V16.25C2.5 16.5815 2.6317 16.8995 2.86612 17.1339C3.10054 17.3683 3.41848 17.5 3.75 17.5H16.25C16.5815 17.5 16.8995 17.3683 17.1339 17.1339C17.3683 16.8995 17.5 16.5815 17.5 16.25V3.75C17.5 3.41848 17.3683 3.10054 17.1339 2.86612C16.8995 2.6317 16.5815 2.5 16.25 2.5ZM11.4328 6.06719C11.3155 5.94991 11.2497 5.79085 11.2497 5.625C11.2497 5.45915 11.3155 5.30009 11.4328 5.18281C11.5501 5.06554 11.7091 4.99965 11.875 4.99965C12.0409 4.99965 12.1999 5.06554 12.3172 5.18281L13.125 5.99141L13.9328 5.18281C14.0501 5.06554 14.2091 4.99965 14.375 4.99965C14.5409 4.99965 14.6999 5.06554 14.8172 5.18281C14.9345 5.30009 15.0003 5.45915 15.0003 5.625C15.0003 5.79085 14.9345 5.94991 14.8172 6.06719L14.0086 6.875L14.8172 7.68281C14.8753 7.74088 14.9213 7.80982 14.9527 7.88569C14.9842 7.96156 15.0003 8.04288 15.0003 8.125C15.0003 8.20712 14.9842 8.28844 14.9527 8.36431C14.9213 8.44018 14.8753 8.50912 14.8172 8.56719C14.7591 8.62526 14.6902 8.67132 14.6143 8.70275C14.5384 8.73417 14.4571 8.75035 14.375 8.75035C14.2929 8.75035 14.2116 8.73417 14.1357 8.70275C14.0598 8.67132 13.9909 8.62526 13.9328 8.56719L13.125 7.75859L12.3172 8.56719C12.1999 8.68446 12.0409 8.75035 11.875 8.75035C11.7091 8.75035 11.5501 8.68446 11.4328 8.56719C11.3155 8.44991 11.2497 8.29085 11.2497 8.125C11.2497 7.95915 11.3155 7.80009 11.4328 7.68281L12.2414 6.875L11.4328 6.06719ZM8.75 13.75H7.5V15C7.5 15.1658 7.43415 15.3247 7.31694 15.4419C7.19973 15.5592 7.04076 15.625 6.875 15.625C6.70924 15.625 6.55027 15.5592 6.43306 15.4419C6.31585 15.3247 6.25 15.1658 6.25 15V13.75H5C4.83424 13.75 4.67527 13.6842 4.55806 13.5669C4.44085 13.4497 4.375 13.2908 4.375 13.125C4.375 12.9592 4.44085 12.8003 4.55806 12.6831C4.67527 12.5658 4.83424 12.5 5 12.5H6.25V11.25C6.25 11.0842 6.31585 10.9253 6.43306 10.8081C6.55027 10.6908 6.70924 10.625 6.875 10.625C7.04076 10.625 7.19973 10.6908 7.31694 10.8081C7.43415 10.9253 7.5 11.0842 7.5 11.25V12.5H8.75C8.91576 12.5 9.07473 12.5658 9.19194 12.6831C9.30915 12.8003 9.375 12.9592 9.375 13.125C9.375 13.2908 9.30915 13.4497 9.19194 13.5669C9.07473 13.6842 8.91576 13.75 8.75 13.75ZM8.75 7.5H5C4.83424 7.5 4.67527 7.43415 4.55806 7.31694C4.44085 7.19973 4.375 7.04076 4.375 6.875C4.375 6.70924 4.44085 6.55027 4.55806 6.43306C4.67527 6.31585 4.83424 6.25 5 6.25H8.75C8.91576 6.25 9.07473 6.31585 9.19194 6.43306C9.30915 6.55027 9.375 6.70924 9.375 6.875C9.375 7.04076 9.30915 7.19973 9.19194 7.31694C9.07473 7.43415 8.91576 7.5 8.75 7.5ZM15 15H11.25C11.0842 15 10.9253 14.9342 10.8081 14.8169C10.6908 14.6997 10.625 14.5408 10.625 14.375C10.625 14.2092 10.6908 14.0503 10.8081 13.9331C10.9253 13.8158 11.0842 13.75 11.25 13.75H15C15.1658 13.75 15.3247 13.8158 15.4419 13.9331C15.5592 14.0503 15.625 14.2092 15.625 14.375C15.625 14.5408 15.5592 14.6997 15.4419 14.8169C15.3247 14.9342 15.1658 15 15 15ZM15 12.5H11.25C11.0842 12.5 10.9253 12.4342 10.8081 12.3169C10.6908 12.1997 10.625 12.0408 10.625 11.875C10.625 11.7092 10.6908 11.5503 10.8081 11.4331C10.9253 11.3158 11.0842 11.25 11.25 11.25H15C15.1658 11.25 15.3247 11.3158 15.4419 11.4331C15.5592 11.5503 15.625 11.7092 15.625 11.875C15.625 12.0408 15.5592 12.1997 15.4419 12.3169C15.3247 12.4342 15.1658 12.5 15 12.5Z" fill="{{ request()->routeIs('kasir') ? '#000000' : '#FFFFFF' }}" />
                    </svg>
                    Kasir
                </a>
            </li>
            <li>
                <a href="{{ route('products') }}" class="flex items-center gap-2 {{ request()->routeIs('products') ? 'text-black font-semibold bg-white p-2 rounded-md' : 'text-white' }}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.3335 5.83335C3.3335 4.72828 3.77248 3.66848 4.55388 2.88708C5.33529 2.10567 6.39509 1.66669 7.50016 1.66669C7.90183 1.66669 8.28183 1.80835 8.4285 2.22252C8.54363 2.54731 8.75656 2.82845 9.038 3.02728C9.31944 3.22611 9.65557 3.33287 10.0002 3.33287C10.3448 3.33287 10.6809 3.22611 10.9623 3.02728C11.2438 2.82845 11.4567 2.54731 11.5718 2.22252C11.7193 1.80835 12.0993 1.66669 12.5002 1.66669C13.6052 1.66669 14.665 2.10567 15.4464 2.88708C16.2278 3.66848 16.6668 4.72828 16.6668 5.83335V6.25002C16.6668 6.58154 16.5351 6.89948 16.3007 7.1339C16.0663 7.36832 15.7484 7.50002 15.4168 7.50002H13.3335C13.3335 8.14169 13.2702 8.79502 13.6985 9.33085L15.3885 11.4434C16.216 12.4777 16.6668 13.7629 16.6668 15.0875V15.8334C16.6668 16.4964 16.4034 17.1323 15.9346 17.6011C15.4658 18.07 14.8299 18.3334 14.1668 18.3334H5.8335C5.17045 18.3334 4.53457 18.07 4.06573 17.6011C3.59689 17.1323 3.3335 16.4964 3.3335 15.8334V15.0875C3.33349 13.7629 3.78432 12.4777 4.61183 11.4434L6.30183 9.33085C6.73016 8.79502 6.66683 8.14252 6.66683 7.50002H4.5835C4.25198 7.50002 3.93403 7.36832 3.69961 7.1339C3.46519 6.89948 3.3335 6.58154 3.3335 6.25002V5.83335Z" fill="{{ request()->routeIs('products') ? '#000000' : '#FFFFFF' }}" />
                    </svg>
                    Produk
                </a>
            </li>
            <li>
                <a href="{{ route('categories') }}" class="flex items-center gap-2 {{ request()->routeIs('categories') ? 'text-black font-semibold bg-white p-2 rounded-md' : 'text-white' }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.1501 3.39998L7.43012 9.47998C7.02012 10.14 7.50012 11 8.28012 11H15.7101C16.4901 11 16.9701 10.14 16.5601 9.47998L12.8501 3.39998C12.7617 3.25362 12.637 3.13256 12.4881 3.04853C12.3392 2.9645 12.1711 2.92035 12.0001 2.92035C11.8291 2.92035 11.661 2.9645 11.5121 3.04853C11.3632 3.13256 11.2385 3.25362 11.1501 3.39998Z" fill="{{ request()->routeIs('categories') ? '#000000' : '#FFFFFF' }}" />
                        <path d="M17.5 22C19.9853 22 22 19.9853 22 17.5C22 15.0147 19.9853 13 17.5 13C15.0147 13 13 15.0147 13 17.5C13 19.9853 15.0147 22 17.5 22Z" fill="{{ request()->routeIs('categories') ? '#000000' : '#FFFFFF' }}" />
                        <path d="M4 21.5H10C10.55 21.5 11 21.05 11 20.5V14.5C11 13.95 10.55 13.5 10 13.5H4C3.45 13.5 3 13.95 3 14.5V20.5C3 21.05 3.45 21.5 4 21.5Z" fill="{{ request()->routeIs('categories') ? '#000000' : '#FFFFFF' }}" />
                    </svg>
                    Category
                </a>
            </li>
            <li>
                <a href="{{ route('sales.index') }}" class="flex items-center gap-2 {{ request()->routeIs('sales.index') ? 'text-black font-semibold bg-white p-2 rounded-md' : 'text-white' }}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.66667 14.1667C6.90278 14.1667 7.10083 14.0867 7.26083 13.9267C7.42083 13.7667 7.50056 13.5689 7.5 13.3333C7.49944 13.0978 7.41944 12.9 7.26 12.74C7.10056 12.58 6.90278 12.5 6.66667 12.5C6.43056 12.5 6.23278 12.58 6.07333 12.74C5.91389 12.9 5.83389 13.0978 5.83333 13.3333C5.83278 13.5689 5.91278 13.7669 6.07333 13.9275C6.23389 14.0881 6.43167 14.1678 6.66667 14.1667ZM6.66667 10.8333C6.90278 10.8333 7.10083 10.7533 7.26083 10.5933C7.42083 10.4333 7.50056 10.2356 7.5 10C7.49944 9.76444 7.41944 9.56667 7.26 9.40667C7.10056 9.24667 6.90278 9.16667 6.66667 9.16667C6.43056 9.16667 6.23278 9.24667 6.07333 9.40667C5.91389 9.56667 5.83389 9.76444 5.83333 10C5.83278 10.2356 5.91278 10.4336 6.07333 10.5942C6.23389 10.7547 6.43167 10.8344 6.66667 10.8333ZM6.66667 7.5C6.90278 7.5 7.10083 7.42 7.26083 7.26C7.42083 7.1 7.50056 6.90222 7.5 6.66667C7.49944 6.43111 7.41944 6.23333 7.26 6.07333C7.10056 5.91333 6.90278 5.83333 6.66667 5.83333C6.43056 5.83333 6.23278 5.91333 6.07333 6.07333C5.91389 6.23333 5.83389 6.43111 5.83333 6.66667C5.83278 6.90222 5.91278 7.10028 6.07333 7.26083C6.23389 7.42139 6.43167 7.50111 6.66667 7.5ZM9.16667 14.1667H14.1667V12.5H9.16667V14.1667ZM9.16667 10.8333H14.1667V9.16667H9.16667V10.8333ZM9.16667 7.5H14.1667V5.83333H9.16667V7.5ZM4.16667 17.5C3.70833 17.5 3.31611 17.3369 2.99 17.0108C2.66389 16.6847 2.50056 16.2922 2.5 15.8333V4.16667C2.5 3.70833 2.66333 3.31611 2.99 2.99C3.31667 2.66389 3.70889 2.50056 4.16667 2.5H15.8333C16.2917 2.5 16.6842 2.66333 17.0108 2.99C17.3375 3.31667 17.5006 3.70889 17.5 4.16667V15.8333C17.5 16.2917 17.3369 16.6842 17.0108 17.0108C16.6847 17.3375 16.2922 17.5006 15.8333 17.5H4.16667Z" fill="{{ request()->routeIs('sales.index') ? '#000000' : '#FFFFFF' }}" />
                    </svg>
                    Daftar Order
                </a>
            </li>
            <li>
                <a href="{{ route('suppliers') }}" class="flex items-center gap-2 {{ request()->routeIs('suppliers') ? 'text-black font-semibold bg-white p-2 rounded-md' : 'text-white' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 1C10.8065 1 9.66193 1.47411 8.81802 2.31802C7.97411 3.16193 7.5 4.30653 7.5 5.5V7H3V23H21V7H16.5V5.5C16.5 4.30653 16.0259 3.16193 15.182 2.31802C14.3381 1.47411 13.1935 1 12 1ZM14.5 5.5V7H9.5V5.5C9.5 4.83696 9.76339 4.20107 10.2322 3.73223C10.7011 3.26339 11.337 3 12 3C12.663 3 13.2989 3.26339 13.7678 3.73223C14.2366 4.20107 14.5 4.83696 14.5 5.5ZM7.5 12V9H9.5V12H7.5ZM14.5 12V9H16.5V12H14.5Z" fill="{{ request()->routeIs('suppliers') ? '#000000' : '#FFFFFF' }}" />
                    </svg>
                    Supplier
                </a>
            </li>
            <li>
                <a href="{{ route('absen') }}" class="flex items-center gap-2 {{ request()->routeIs('absen') ? 'text-black font-semibold bg-white p-2 rounded-md' : 'text-white' }}">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.9375 13.125H13.4375C13.2649 13.125 13.125 13.2649 13.125 13.4375V15.9375C13.125 16.1101 13.2649 16.25 13.4375 16.25H15.9375C16.1101 16.25 16.25 16.1101 16.25 15.9375V13.4375C16.25 13.2649 16.1101 13.125 15.9375 13.125Z" fill="{{ request()->routeIs('absen') ? '#000000' : '#FFFFFF' }}" />
                        <path d="M12.8125 10.625H10.9375C10.7649 10.625 10.625 10.7649 10.625 10.9375V12.8125C10.625 12.9851 10.7649 13.125 10.9375 13.125H12.8125C12.9851 13.125 13.125 12.9851 13.125 12.8125V10.9375C13.125 10.7649 12.9851 10.625 12.8125 10.625Z" fill="{{ request()->routeIs('absen') ? '#000000' : '#FFFFFF' }}" />
                        <path d="M18.4375 16.25H16.5625C16.3899 16.25 16.25 16.3899 16.25 16.5625V18.4375C16.25 18.6101 16.3899 18.75 16.5625 18.75H18.4375C18.6101 18.75 18.75 18.6101 18.75 18.4375V16.5625C18.75 16.3899 18.6101 16.25 18.4375 16.25Z" fill="{{ request()->routeIs('absen') ? '#000000' : '#FFFFFF' }}" />
                        <path d="M18.4375 10.625H17.1875C17.0149 10.625 16.875 10.7649 16.875 10.9375V12.1875C16.875 12.3601 17.0149 12.5 17.1875 12.5H18.4375C18.6101 12.5 18.75 12.3601 18.75 12.1875V10.9375C18.75 10.7649 18.6101 10.625 18.4375 10.625Z" fill="{{ request()->routeIs('absen') ? '#000000' : '#FFFFFF' }}" />
                        <path d="M12.1875 16.875H10.9375C10.7649 16.875 10.625 17.0149 10.625 17.1875V18.4375C10.625 18.6101 10.7649 18.75 10.9375 18.75H12.1875C12.3601 18.75 12.5 18.6101 12.5 18.4375V17.1875C12.5 17.0149 12.3601 16.875 12.1875 16.875Z" fill="{{ request()->routeIs('absen') ? '#000000' : '#FFFFFF' }}" />
                        <path d="M17.5 1.25H11.875C11.5435 1.25 11.2255 1.3817 10.9911 1.61612C10.7567 1.85054 10.625 2.16848 10.625 2.5V8.125C10.625 8.45652 10.7567 8.77446 10.9911 9.00888C11.2255 9.2433 11.5435 9.375 11.875 9.375H17.5C17.8315 9.375 18.1495 9.2433 18.3839 9.00888C18.6183 8.77446 18.75 8.45652 18.75 8.125V2.5C18.75 2.16848 18.6183 1.85054 18.3839 1.61612C18.1495 1.3817 17.8315 1.25 17.5 1.25ZM16.25 6.5625C16.25 6.64538 16.2171 6.72487 16.1585 6.78347C16.0999 6.84208 16.0204 6.875 15.9375 6.875H13.4375C13.3546 6.875 13.2751 6.84208 13.2165 6.78347C13.1579 6.72487 13.125 6.64538 13.125 6.5625V4.0625C13.125 3.97962 13.1579 3.90013 13.2165 3.84153C13.2751 3.78292 13.3546 3.75 13.4375 3.75H15.9375C16.0204 3.75 16.0999 3.78292 16.1585 3.84153C16.2171 3.90013 16.25 3.97962 16.25 4.0625V6.5625ZM8.125 1.25H2.5C2.16848 1.25 1.85054 1.3817 1.61612 1.61612C1.3817 1.85054 1.25 2.16848 1.25 2.5V8.125C1.25 8.45652 1.3817 8.77446 1.61612 9.00888C1.85054 9.2433 2.16848 9.375 2.5 9.375H8.125C8.45652 9.375 8.77446 9.2433 9.00888 9.00888C9.2433 8.77446 9.375 8.45652 9.375 8.125V2.5C9.375 2.16848 9.2433 1.85054 9.00888 1.61612C8.77446 1.3817 8.45652 1.25 8.125 1.25ZM6.875 6.5625C6.875 6.64538 6.84208 6.72487 6.78347 6.78347C6.72487 6.84208 6.64538 6.875 6.5625 6.875H4.0625C3.97962 6.875 3.90013 6.84208 3.84153 6.78347C3.78292 6.72487 3.75 6.64538 3.75 6.5625V4.0625C3.75 3.97962 3.78292 3.90013 3.84153 3.84153C3.90013 3.78292 3.97962 3.75 4.0625 3.75H6.5625C6.64538 3.75 6.72487 3.78292 6.78347 3.84153C6.84208 3.90013 6.875 3.97962 6.875 4.0625V6.5625ZM8.125 10.625H2.5C2.16848 10.625 1.85054 10.7567 1.61612 10.9911C1.3817 11.2255 1.25 11.5435 1.25 11.875V17.5C1.25 17.8315 1.3817 18.1495 1.61612 18.3839C1.85054 18.6183 2.16848 18.75 2.5 18.75H8.125C8.45652 18.75 8.77446 18.6183 9.00888 18.3839C9.2433 18.1495 9.375 17.8315 9.375 17.5V11.875C9.375 11.5435 9.2433 11.2255 9.00888 10.9911C8.77446 10.7567 8.45652 10.625 8.125 10.625ZM6.875 15.9375C6.875 16.0204 6.84208 16.0999 6.78347 16.1585C6.72487 16.2171 6.64538 16.25 6.5625 16.25H4.0625C3.97962 16.25 3.90013 16.2171 3.84153 16.1585C3.78292 16.0999 3.75 16.0204 3.75 15.9375V13.4375C3.75 13.3546 3.78292 13.2751 3.84153 13.2165C3.90013 13.1579 3.97962 13.125 4.0625 13.125H6.5625C6.64538 13.125 6.72487 13.1579 6.78347 13.2165C6.84208 13.2751 6.875 13.3546 6.875 13.4375V15.9375Z" fill="{{ request()->routeIs('absen') ? '#000000' : '#FFFFFF' }}" />
                    </svg>
                    Absensi
                </a>
            </li>
        </ul>

        <div class="absolute bottom-8 left-0 right-0 px-4">
            <div class="relative">
                <div class="flex items-center space-x-4 cursor-pointer" onclick="toggleDropdown()">
                    <div class="w-8 h-8 bg-gray-700 rounded-full flex-shrink-0"></div>
                    <div class="text-white overflow-hidden">
                        <div class="font-semibold text-sm truncate">{{ Auth::user()->name }}</div>
                        <div class="text-gray-400 text-xs">{{ ucfirst(Auth::user()->role) }}</div>
                    </div>
                    <svg class="w-4 h-4 text-white flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div id="dropdownMenu" class="absolute bottom-full left-0 mb-2 w-40 bg-white rounded-md shadow-lg z-50 transform scale-95 opacity-0 transition-all duration-200 ease-out hidden">
                    <a href="{{ route('absen.qr-code') }}" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-t-md font-semibold">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100 hover:text-gray-900 rounded-b-md font-semibold">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    <div class="flex-1 bg-white min-h-screen">
        <div class="p-4 lg:hidden">
            <button id="menu-button" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        @yield('content')
    </div>
</div>

<script>
    // --- Loading Overlay Logic ---
    const loadingOverlay = document.getElementById('loading-overlay');

    function showLoader() {
        if (loadingOverlay) {
            loadingOverlay.style.display = 'flex';
        }
    }

    function hideLoader() {
        if (loadingOverlay) {
            loadingOverlay.style.display = 'none';
        }
    }

    // Show loader on link clicks (excluding those opening in a new tab)
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(event) {
            // Check if the link opens in a new tab
            if (event.ctrlKey || event.metaKey || link.target === '_blank') {
                return;
            }
            // Check if it's a javascript link
            if(link.href.startsWith('javascript:')) {
                return;
            }
            showLoader();
        });
    });

    // Show loader on form submissions (excluding delete forms)
    document.querySelectorAll('form').forEach(form => {
        if (!form.classList.contains('delete-form')) {
            form.addEventListener('submit', function() {
                showLoader();
            });
        }
    });

    // Hide loader when the page is shown (e.g., when using back/forward buttons)
    window.addEventListener('pageshow', function(event) {
        // The persisted property is false on initial load
        if (event.persisted) {
            hideLoader();
        }
    });

    // --- Responsive Sidebar Logic ---
    const sidebar = document.getElementById('sidebar');
    const menuButton = document.getElementById('menu-button');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');
        sidebarOverlay.classList.toggle('hidden');
    }

    menuButton.addEventListener('click', toggleSidebar);
    sidebarOverlay.addEventListener('click', toggleSidebar);

    // --- User Dropdown Logic ---
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownMenu');

        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            setTimeout(() => {
                dropdown.classList.remove('scale-95', 'opacity-0');
                dropdown.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            dropdown.classList.remove('scale-100', 'opacity-100');
            dropdown.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 200);
        }
    }

    window.addEventListener('click', function(event) {
        // Close dropdown if clicked outside
        if (!event.target.closest('.relative')) {
            const dropdown = document.getElementById('dropdownMenu');
            if (dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('scale-100', 'opacity-100');
                dropdown.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    dropdown.classList.add('hidden');
                }, 200);
            }
        }
    });

    // --- SweetAlert2 Delete Confirmation Logic ---
    document.querySelectorAll('.delete-form').forEach((form) => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tindakan ini akan menghapus data secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loader just before submitting the confirmed delete form
                    showLoader();
                    form.submit();
                }
            });
        });
    });
</script>
@livewireScripts
</body>
</html>
