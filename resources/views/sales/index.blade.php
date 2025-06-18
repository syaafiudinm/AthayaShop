@extends('layouts.app')

@section('content')
<div class="flex-1 p-8">
    <h1 class="text-3xl font-bold mb-6">Daftar Order</h1>

    <div class="mt-4 mb-4">
        @include('components.alert')
    </div>

    {{-- Filter --}}
    <div class="flex items-center gap-4 mb-6 max-sm:flex-col">
        <a href="{{ route('sales.index') }}" class="btn border border-gray-300 p-2 rounded-md max-sm:w-full">Semua</a>
        <a href="{{ route('sales.index', ['status' => 'pending']) }}" class="btn p-2 border border-gray-300 rounded-md max-sm:w-full">Dalam Proses</a>
        <a href="{{ route('sales.index', ['status' => 'paid']) }}" class="btn p-2 border border-gray-300 rounded-md max-sm:w-full">Selesai</a>

        <div class="md:ml-auto max-sm:w-full">
            <form>
                <input type="text" name="search" placeholder="Cari" class="input p-2 border border-gray-300 rounded-md " value="{{ request('search') }}">
            </form>
        </div>
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($sales as $sale)
            <div class="border border-gray-300 rounded-md shadow p-4 space-y-3 flex flex-col justify-between h-full">
                <div> <div class="flex justify-between items-start">
                        <div>
                            <h2 class="font-bold">Order #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h2>
                            <p class="text-sm text-gray-500">{{ $sale->user->name }} - Kasir</p>
                            <p class="text-xs text-gray-400">{{ $sale->created_at->format('l, d F Y') }}</p>
                        </div>

                        <span class="flex-shrink-0 ml-4 text-sm px-2 py-1 rounded bg-blue-100 text-blue-600">
                        {{ ucfirst($sale->status) }}
                    </span>
                    </div>
                    <hr class="mt-3">
                    <div class="divide-y text-sm">
                        @foreach ($sale->items->take(3) as $item)
                            <div class="flex justify-between py-1">
                                <span>{{ $item->product->name }}</span>
                                <div class="flex-shrink-0">
                                    <span>x{{ $item->total }}</span>
                                    <span class="inline-block w-24 text-right">Rp{{ number_format($item->unit_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach
                        @if ($sale->items->count() > 3)
                            <p class="text-xs text-gray-500 pt-1">+{{ $sale->items->count() - 3 }} Barang lainnya</p>
                        @endif
                    </div>
                </div>

                <div>
                    <hr>
                    <div class="pt-2 font-semibold">
                        <div class="flex justify-between">
                            <span>Total</span>
                            <span>Rp{{ number_format($sale->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-sm text-gray-600 font-normal">Metode Pembayaran: {{ ucfirst($sale->payment_method) }}</div>
                    </div>

                    <button
                        data-sale-id="{{ $sale->id }}"
                        class="mt-3 inline-block text-center w-full bg-black text-white py-2 rounded-md text-sm font-medium open-modal"
                    >
                        Lihat Detail
                    </button>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500 py-10">Order belum ada.</p>
        @endforelse
    </div>
    @if ($sales->isNotEmpty())
    <div class="mt-6">
        {{ $sales->links('pagination::tailwind') }}
    </div>
    @endif

    <!-- Modal -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-96 relative">
            <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" id="closeModal">×</button>
            <h2 class="text-2xl font-bold mb-4">Detail Order</h2>
            <div id="modalContent">
                <!-- Dynamic content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.open-modal').forEach(button => {
    button.addEventListener('click', function() {
        const saleId = this.getAttribute('data-sale-id');
        fetch(`/sales/${saleId}/detail`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('detailModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching details:', error);
                document.getElementById('modalContent').innerHTML = '<p class="text-red-500">Terjadi kesalahan saat mengambil detail.</p>';
                document.getElementById('detailModal').classList.remove('hidden');
            });
    });
});

document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('detailModal').classList.add('hidden');
});
</script>
@endsection
