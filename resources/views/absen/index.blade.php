@extends('layouts.app')

@section('content')
    <div class="flex-1 p-8">
        <h1 class="text-3xl font-semibold mb-4">Absen</h1>
        <div class="flex items-center gap-3">
            <div class="flex gap-3">
                <a href="{{ route('absen') }}" class="flex items-center border border-gray-300 p-2 rounded-md gap-2 mt-1">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.15 3.36878C11.3254 3.48823 11.4461 3.67245 11.4856 3.88092C11.5252 4.08938 11.4803 4.30502 11.3608 4.48038C11.2413 4.65574 11.0571 4.77646 10.8487 4.816C10.6402 4.85553 10.4246 4.81063 10.2492 4.69118C9.51062 4.18909 8.62525 3.94861 7.73415 4.00805C6.84305 4.0675 5.99747 4.42345 5.33213 5.01919C4.66679 5.61494 4.21995 6.41621 4.06281 7.29536C3.90566 8.1745 4.04725 9.08096 4.46502 9.8703C4.88278 10.6596 5.55269 11.2865 6.36802 11.6509C7.18335 12.0154 8.0972 12.0965 8.96398 11.8814C9.83076 11.6662 10.6006 11.1672 11.1509 10.4638C11.7012 9.76039 12.0002 8.89306 12.0004 7.99998C12.0004 7.7878 12.0847 7.58432 12.2347 7.43429C12.3847 7.28426 12.5882 7.19998 12.8004 7.19998C13.0126 7.19998 13.2161 7.28426 13.3661 7.43429C13.5161 7.58432 13.6004 7.7878 13.6004 7.99998C13.6002 9.25037 13.1815 10.4647 12.4111 11.4496C11.6407 12.4344 10.5628 13.1331 9.34922 13.4342C8.13564 13.7354 6.85618 13.6218 5.71469 13.1114C4.57319 12.601 3.63534 11.7233 3.05056 10.6181C2.46578 9.51289 2.26772 8.24375 2.48792 7.0129C2.70813 5.78205 3.33394 4.66031 4.26564 3.82639C5.19734 2.99248 6.38134 2.49438 7.62897 2.41144C8.87661 2.32851 10.1161 2.66552 11.15 3.36878Z" fill="black"/>
                        <path d="M10.8319 10.0048C10.7434 10.0614 10.6446 10.1 10.5412 10.1185C10.4377 10.1369 10.3317 10.1348 10.229 10.1123C10.1264 10.0897 10.0292 10.0472 9.94303 9.98707C9.85685 9.92697 9.78334 9.85048 9.72672 9.76197C9.67009 9.67346 9.63145 9.57466 9.61301 9.47122C9.59456 9.36777 9.59668 9.26171 9.61922 9.15908C9.64177 9.05646 9.68431 8.95927 9.74441 8.87309C9.80451 8.7869 9.88101 8.71339 9.96952 8.65677L12.7551 6.87517C12.9338 6.76457 13.1489 6.72874 13.3538 6.77541C13.5587 6.82208 13.737 6.94751 13.8502 7.12459C13.9634 7.30167 14.0023 7.51617 13.9586 7.72174C13.915 7.9273 13.7921 8.10742 13.6167 8.22317L10.8319 10.0048Z" fill="black"/>
                        <path d="M15.123 9.92798C15.2047 10.1209 15.2074 10.3382 15.1306 10.5331C15.0538 10.728 14.9036 10.885 14.7123 10.9704C14.521 11.0558 14.3039 11.0627 14.1075 10.9897C13.9112 10.9167 13.7513 10.7696 13.6622 10.58L12.4558 7.87598C12.4106 7.77971 12.385 7.67539 12.3806 7.56913C12.3762 7.46286 12.393 7.35677 12.43 7.25708C12.4671 7.15738 12.5237 7.06608 12.5964 6.98851C12.6692 6.91094 12.7567 6.84865 12.8538 6.8053C12.9509 6.76195 13.0557 6.73841 13.1621 6.73604C13.2684 6.73367 13.3742 6.75253 13.4731 6.79152C13.5721 6.8305 13.6623 6.88883 13.7384 6.96308C13.8146 7.03734 13.8751 7.12604 13.9166 7.22398L15.123 9.92798Z" fill="black"/>
                    </svg>
                    Refresh                 
                </a>
                <a href="{{ route('absen.scan') }}" class="flex items-center border border-gray-300 px-4 py-2 rounded-md gap-2 mt-1">
                    Absen 
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.167 10.8334H5.00033C4.76422 10.8334 4.56644 10.7534 4.407 10.5934C4.24755 10.4334 4.16755 10.2356 4.167 10C4.16644 9.76447 4.24644 9.56669 4.407 9.40669C4.56755 9.24669 4.76533 9.16669 5.00033 9.16669H9.167V5.00002C9.167 4.76391 9.24699 4.56613 9.40699 4.40669C9.567 4.24725 9.76477 4.16725 10.0003 4.16669C10.2359 4.16613 10.4339 4.24613 10.5945 4.40669C10.7551 4.56725 10.8348 4.76502 10.8337 5.00002V9.16669H15.0003C15.2364 9.16669 15.4345 9.24669 15.5945 9.40669C15.7545 9.56669 15.8342 9.76447 15.8337 10C15.8331 10.2356 15.7531 10.4336 15.5937 10.5942C15.4342 10.7547 15.2364 10.8345 15.0003 10.8334H10.8337V15C10.8337 15.2361 10.7537 15.4342 10.5937 15.5942C10.4337 15.7542 10.2359 15.8339 10.0003 15.8334C9.76477 15.8328 9.567 15.7528 9.40699 15.5934C9.24699 15.4339 9.167 15.2361 9.167 15V10.8334Z" fill="black"/>
                    </svg>             
                </a>
            </div>
            <form method="GET" action="{{ route('absen') }}" class="flex items-center border border-gray-300 rounded-lg p-2 ml-auto md:w-1/3">
                <!-- Search Icon -->
                <span class="text-gray-500 mr-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.0667 14L8.86667 9.8C8.53333 10.0667 8.15 10.2778 7.71667 10.4333C7.28333 10.5889 6.82222 10.6667 6.33333 10.6667C5.12222 10.6667 4.09733 10.2471 3.25867 9.408C2.42 8.56889 2.00044 7.544 2 6.33333C1.99956 5.12267 2.41911 4.09778 3.25867 3.25867C4.09822 2.41956 5.12311 2 6.33333 2C7.54356 2 8.56867 2.41956 9.40867 3.25867C10.2487 4.09778 10.668 5.12267 10.6667 6.33333C10.6667 6.82222 10.5889 7.28333 10.4333 7.71667C10.2778 8.15 10.0667 8.53333 9.8 8.86667L14 13.0667L13.0667 14ZM6.33333 9.33333C7.16667 9.33333 7.87511 9.04178 8.45867 8.45867C9.04222 7.87556 9.33378 7.16711 9.33333 6.33333C9.33289 5.49956 9.04133 4.79133 8.45867 4.20867C7.876 3.626 7.16756 3.33422 6.33333 3.33333C5.49911 3.33244 4.79089 3.62422 4.20867 4.20867C3.62644 4.79311 3.33467 5.50133 3.33333 6.33333C3.332 7.16533 3.62378 7.87378 4.20867 8.45867C4.79356 9.04356 5.50178 9.33511 6.33333 9.33333Z" fill="black"/>
                    </svg>                        
                </span>
                <!-- Search Input -->
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari"
                    class="w-full bg-transparent border-none focus:ring-0 focus:outline-none placeholder-gray-500 text-gray-700" />
            </form>
        </div>
        <div class="flex items-center gap-6 mt-8">
            <div class="max-w-md p-6 bg-[#C7EEFF] border-2 border-gray-200 rounded-lg shadow-md flex items-center gap-6">
            <!-- Progress Circle -->
                <canvas id="attendanceChart" width="100" height="100"></canvas>
                
                <!-- Text info -->
                <div>
                    <h2 class="text-lg font-bold text-black mb-1">Kehadiran Karyawan</h2>
                    <p class="text-sm text-black mb-4">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMM YYYY') }}</p>
                    
                    <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-black" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path fill-rule="evenodd" d="M4 14s1-1.5 4-1.5 4 1.5 4 1.5v1H4v-1z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-semibold text-black">Jumlah Orang</span>
                    </div>
                    
                    <p class="text-4xl font-extrabold text-black mt-1">
                    {{ $hadirCount }}<span class="text-lg font-normal">/{{ $totalUsers }}</span>
                    </p>
                </div>
            </div>
            <div class="max-w-md p-6 bg-[#C7EEFF] border-2 border-gray-200 rounded-lg shadow-md">
                    <div>
                        <h2 class="text-lg font-bold text-black mb-1">Total Seluruh Karyawan</h2>
                        <p class="text-sm text-black mb-4">{{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMM YYYY') }}</p>
                        <div class="flex gap-10 mt-10">
                            <p class="text-4xl font-extrabold text-black">
                                {{ $totalAdmin }} <span class="text-lg font-normal">Admin</span>
                            </p>
                            <p class="text-4xl font-extrabold text-black">
                                {{ $totalKasir }} <span class="text-lg font-normal">Kasir</span>
                            </p>
                        </div>
                    </div>
            </div>
        </div>

        <div class="mt-4 mb-4">
            @include('components.alert')
        </div>

        <div>
            <table class="w-full mt-6 border-separate border-spacing-y-3">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-left px-6 py-3 text-white font-normal rounded-l-lg">NO.</th>
                        <th class="text-left px-6 py-3 text-white font-normal">Nama Pegawai</th>
                        <th class="text-left px-6 py-3 text-white font-normal">Tanggal</th>
                        <th class="text-left px-6 py-3 text-white font-normal">Check In</th>
                        @if (auth()->user()->role !== 'owner')
                        <th class="text-left px-6 py-3 text-white font-normal">Informasi</th>
                        <th class="text-left px-6 py-3 text-white font-normal rounded-r-lg">Approval</th>
                        @endif
                        @if (auth()->user()->role === 'owner')
                            <th class="text-left px-6 py-3 text-white font-normal">Informasi</th>
                            <th class="text-left px-6 py-3 text-white font-normal">Status</th>
                            <th class="text-left px-6 py-3 text-white font-normal rounded-r-lg">Dokumen</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absens as $absen)
                        <tr class="rounded-lg shadow border border-gray-800 overflow-hidden">
                            <td class="px-4 py-2 font-semibold">{{ $loop->iteration + ($absens->currentPage() - 1) * $absens->perPage() }}</td>
                            <td class="px-4 py-2 font-medium">{{ $absen->user->name }}</td>
                            <td class="px-4 py-2 font-medium">{{ $absen->created_at->format('d F Y') }}</td>
                            <td class="px-4 py-2 font-medium">{{ $absen->check_in }}</td>
                            <td class="px-4 py-2 font-medium">{{ $absen->status }}</td>

                            @if(auth()->user()->role === 'owner' && in_array($absen->status, ['Sakit', 'Izin']))
                                <td class="px-4 py-2 font-medium">
                                    @if($absen->approval_status === 'Pending')
                                        <form action="{{ route('absen.approval', $absen->id) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <button name="action" value="approve" class="px-4 py-2 text-gray-600 border border-1 border-gray-300 rounded-md">Terima</button>
                                            <button name="action" value="reject" class="px-4 py-2 text-gray-600 border border-1 border-gray-300 rounded-md">Tolak</button>
                                        </form>
                                    @else
                                        <span class="{{ $absen->approval_status === 'Approved' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $absen->approval_status }}
                                        </span>
                                    @endif
                                </td>
                            @endif
                            @if (auth()->user()->role === 'owner')
                                <td class="px-4 py-2 font-medium">
                                    @if($absen->dokumen)
                                        <a href="{{ asset('storage/' . $absen->dokumen) }}" target="_blank" class="text-blue-600 underline">Lihat Dokumen</a>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                            @endif
                            @if (auth()->user()->role !== 'owner') 
                                <td class="px-4 py-2 font-medium">
                                    @if($absen->status === 'Sakit' || $absen->status === 'Izin')
                                        @if($absen->approval_status === 'Approved')
                                            <span class="text-green-600 font-semibold">Disetujui</span>
                                        @elseif($absen->approval_status === 'Rejected')
                                            <span class="text-red-600 font-semibold">Ditolak</span>
                                        @else
                                            <span class="text-yellow-600 font-semibold">Menunggu</span>
                                        @endif
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>

            </table>
            @if ($absens->isNotEmpty())
            <div class="mt-6">
                {{ $absens->links('pagination::tailwind') }}
            </div>                          
            @endif       
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('attendanceChart').getContext('2d');
  const hadirCount = {{ $hadirCount }};
  const tidakHadir = {{ $totalUsers - $hadirCount}};
  const attendanceChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
          datasets: [{
              data: [hadirCount, tidakHadir],
              backgroundColor: ['#0077C0', '#FFFFFF66'], // biru tua & biru muda
              borderWidth: 0
          }]
      },
      options: {
          cutout: '80%',
          responsive: false,
          plugins: {
              tooltip: {enabled: false},
              legend: {display: false}
          }
      }
  });
</script>
@endsection