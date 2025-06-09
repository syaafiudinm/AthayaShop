@extends('layouts.app')

@section('content')
    <main class="flex-1 p-4 sm:p-8 bg-gray-50">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0">Beranda</h1>
            <div class="flex items-center gap-2 bg-white p-2 rounded-lg shadow-sm">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 7V3M16 7V3M4 11H20M5 21H19C19.5304 21 20.0391 20.7893 20.4142 20.4142C20.7893 20.0391 21 19.5304 21 19V7C21 6.46957 20.7893 5.96086 20.4142 5.58579C20.0391 5.21071 19.5304 5 19 5H5C4.46957 5 3.96086 5.21071 3.58579 5.58579C3.21071 5.96086 3 6.46957 3 7V19C3 19.5304 3.21071 20.0391 3.58579 20.4142C3.96086 20.7893 4.46957 21 5 21Z" stroke="#4B5563" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-gray-600 font-semibold">{{ $tanggal }}</span>
            </div>
        </div>

        <div class="space-y-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-[#C7EEFF] p-6 rounded-2xl shadow-sm flex items-end justify-between">
                            <div>
                                <p class="text-gray-800 font-bold text-sm mb-4">Total Transaksi</p>
                                <p class="text-4xl font-bold text-gray-800">{{ $TotalOrder }}</p>
                            </div>
                            <div>
                                <svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.66667 14.1667C6.90278 14.1667 7.10083 14.0867 7.26083 13.9267C7.42083 13.7667 7.50056 13.5689 7.5 13.3333C7.49944 13.0978 7.41944 12.9 7.26 12.74C7.10056 12.58 6.90278 12.5 6.66667 12.5C6.43056 12.5 6.23278 12.58 6.07333 12.74C5.91389 12.9 5.83389 13.0978 5.83333 13.3333C5.83278 13.5689 5.91278 13.7669 6.07333 13.9275C6.23389 14.0881 6.43167 14.1678 6.66667 14.1667ZM6.66667 10.8333C6.90278 10.8333 7.10083 10.7533 7.26083 10.5933C7.42083 10.4333 7.50056 10.2356 7.5 10C7.49944 9.76444 7.41944 9.56667 7.26 9.40667C7.10056 9.24667 6.90278 9.16667 6.66667 9.16667C6.43056 9.16667 6.23278 9.24667 6.07333 9.40667C5.91389 9.56667 5.83389 9.76444 5.83333 10C5.83278 10.2356 5.91278 10.4336 6.07333 10.5942C6.23389 10.7547 6.43167 10.8344 6.66667 10.8333ZM6.66667 7.5C6.90278 7.5 7.10083 7.42 7.26083 7.26C7.42083 7.1 7.50056 6.90222 7.5 6.66667C7.49944 6.43111 7.41944 6.23333 7.26 6.07333C7.10056 5.91333 6.90278 5.83333 6.66667 5.83333C6.43056 5.83333 6.23278 5.91333 6.07333 6.07333C5.91389 6.23333 5.83389 6.43111 5.83333 6.66667C5.83278 6.90222 5.91278 7.10028 6.07333 7.26083C6.23389 7.42139 6.43167 7.50111 6.66667 7.5ZM9.16667 14.1667H14.1667V12.5H9.16667V14.1667ZM9.16667 10.8333H14.1667V9.16667H9.16667V10.8333ZM9.16667 7.5H14.1667V5.83333H9.16667V7.5ZM4.16667 17.5C3.70833 17.5 3.31611 17.3369 2.99 17.0108C2.66389 16.6847 2.50056 16.2922 2.5 15.8333V4.16667C2.5 3.70833 2.66333 3.31611 2.99 2.99C3.31667 2.66389 3.70889 2.50056 4.16667 2.5H15.8333C16.2917 2.5 16.6842 2.66333 17.0108 2.99C17.3375 3.31667 17.5006 3.70889 17.5 4.16667V15.8333C17.5 16.2917 17.3369 16.6842 17.0108 17.0108C16.6847 17.3375 16.2922 17.5006 15.8333 17.5H4.16667Z" fill="black" />
                                </svg>
                            </div>
                        </div>
                        <div class="bg-[#C7EEFF] p-6 rounded-2xl shadow-sm">
                            <p class="text-gray-800 font-bold text-sm mb-4">Total Barang</p>
                            <div class="flex flex-wrap items-end gap-x-6 gap-y-2 mt-2">
                                @foreach ($categories as $category)
                                    <div class="flex items-end gap-2">
                                        <p class="text-4xl font-bold text-gray-800">{{ $category->products->count() }}</p>
                                        <p class="text-gray-600 mb-1 whitespace-nowrap">{{ $category->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#0077C0] text-white p-6 rounded-2xl shadow-sm">
                    <p class="text-blue-200 text-sm">Total Pemasukan</p>
                    @if ($newestIncome > 0)
                        <p class="text-xs outline outline-white px-2 py-1 rounded-full inline-block mt-2">Rp.{{ number_format($newestIncome, 0, ',', '.') }}</p>
                    @else
                        <p class="text-xs outline outline-white px-2 py-1 rounded-full inline-block mt-2">Rp.0</p>
                    @endif
                    @if ($totalIncome > 0)
                        <p class="text-3xl sm:text-4xl font-bold mt-2">Rp.{{ number_format($totalIncome, 0, ',', '.') }}</p>
                    @else
                        <p class="text-3xl sm:text-4xl font-bold mt-2">Rp.0</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Kehadiran Karyawan</h3>
                    <div class="grid grid-cols-3 gap-4 text-center py-4">
                        <div class="flex flex-col items-center space-y-2">
                            <div id="chartHadir"></div>
                            <p class="font-semibold text-gray-600 -mt-2">Hadir</p>
                        </div>
                        <div class="flex flex-col items-center space-y-2">
                            <div id="chartSakit"></div>
                            <p class="font-semibold text-gray-600 -mt-2">Sakit</p>
                        </div>
                        <div class="flex flex-col items-center space-y-2">
                            <div id="chartIzin"></div>
                            <p class="font-semibold text-gray-600 -mt-2">Izin</p>
                        </div>
                    </div>
                </div>
                <div class="bg-[#C7EEFF] p-6 rounded-2xl shadow-sm text-center flex flex-col justify-center">
                    <p class="font-semibold text-gray-500">Waktu</p>
                    <p class="text-4xl sm:text-5xl font-bold text-gray-800 my-2">{{ $witaNow }}</p>
                    <p class="text-gray-600">
                        <svg class="inline-block w-4 h-4 -mt-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" />
                        </svg>
                        Makassar, Sulawesi Selatan
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Riwayat Transaksi</h3>
                    <div class="overflow-x-auto">
                        <div class="space-y-3 min-w-[500px]">
                            <div class="grid grid-cols-3 text-sm font-semibold text-gray-500 bg-gray-100 p-2 rounded-lg">
                                <div class="text-center">ID Transaksi</div>
                                <div class="text-center">Waktu</div>
                                <div class="text-center">Nama Kasir</div>
                            </div>
                            @forelse($sales as $sale)
                                <div class="grid grid-cols-3 items-center text-sm text-gray-700 hover:bg-gray-50 p-2 rounded-lg">
                                    <div class="font-semibold text-center">#{{ $sale->id }}</div>
                                    <div class="text-center">{{ $sale->created_at->format('d M Y, H:i') }}</div>
                                    <div class="text-center">{{ $sale->user->name }}</div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 py-4">Belum ada transaksi.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Stok Produk</h3>
                    <div class="overflow-x-auto">
                        <div class="space-y-2 min-w-[400px]">
                            <div class="grid grid-cols-4 text-sm font-semibold text-gray-500 bg-gray-100 p-2 rounded-lg">
                                <div class="col-span-2">Nama Produk</div>
                                <div class="text-center">Terjual</div>
                                <div class="text-center">Stok</div>
                            </div>
                            @forelse($products as $product)
                                <div class="grid grid-cols-4 items-center text-sm text-gray-700 hover:bg-gray-50 p-2 rounded-lg">
                                    <div class="col-span-2">
                                        <p class="font-semibold">#00{{ $product->id }}</p>
                                        <p class="text-xs text-gray-400 truncate">{{ $product->name }}</p>
                                    </div>
                                    <div class="font-medium text-center">{{ $product->salesItems->count() }}</div>
                                    <div class="font-medium text-center">{{ $product->stock }}</div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500 py-4">Belum ada produk.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Wait for the DOM to be fully loaded before running the script
        document.addEventListener('DOMContentLoaded', function() {
            const commonChartOptions = {
                chart: {
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                name: { show: false },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 'bold',
                                    color: '#1f2937',
                                    offsetY: 8,
                                    formatter: (val) => val,
                                },
                                total: { show: false }
                            }
                        }
                    }
                },
                stroke: { width: 0 },
                legend: { show: false },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: (val) => `${val} Orang`,
                        title: { formatter: (seriesName) => seriesName },
                    },
                },
                // Add the responsive configuration
                responsive: [{
                    breakpoint: 480, // This is a typical mobile breakpoint
                    options: {
                        chart: {
                            width: '100%' // Ensure chart width fits container on small screens
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    labels: {
                                        value: {
                                            fontSize: '18px' // Use a smaller font for the value on mobile
                                        }
                                    }
                                }
                            }
                        }
                    }
                }]
            };

            // 1. Hadir Chart
            const optionsHadir = {
                ...commonChartOptions,
                series: [{{ $hadirCount }}],
                labels: ['Hadir'],
                colors: ['#3B82F6'],
            };
            const chartHadir = new ApexCharts(document.querySelector("#chartHadir"), optionsHadir);
            chartHadir.render();

            // 2. Sakit Chart
            const optionsSakit = {
                ...commonChartOptions,
                series: [{{ $sakitCount }}],
                labels: ['Sakit'],
                colors: ['#EF4444'],
            };
            const chartSakit = new ApexCharts(document.querySelector("#chartSakit"), optionsSakit);
            chartSakit.render();

            // 3. Izin Chart
            const optionsIzin = {
                ...commonChartOptions,
                series: [{{ $izinCount }}],
                labels: ['Izin'],
                colors: ['#FBBF24'],
            };
            const chartIzin = new ApexCharts(document.querySelector("#chartIzin"), optionsIzin);
            chartIzin.render();
        });
    </script>

@endsection
