<div>
    <div class="flex justify-between">
        <div>
            <h3 class="font-bold">Order #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h3>
            <p class="text-sm text-gray-500">{{ $sale->user->name }} - Kasir</p>
            <p class="text-xs text-gray-400">{{ $sale->created_at->format('l, d F Y') }} {{ $sale->created_at->format('H:i') }} WITA</p>
        </div>
        <div>
            <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-600">Dalam Proses</span>
        </div>
    </div>
    <hr class="my-4">
    <table class="w-full text-sm">
        <thead>
            <tr>
                <th class="text-left py-2">Barang</th>
                <th class="text-left py-2">Qty</th>
                <th class="text-left py-2">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
                <tr>
                    <td class="text-left py-1">{{ $item->product->name }}</td>
                    <td class="text-left py-1">{{ $item->total }}</td>
                    <td class="text-left py-1">Rp{{ number_format($item->unit_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <hr class="my-4">
    <div class="font-semibold">
        <div class="flex justify-between">
            <span>TOTAL</span>
            <span>Rp{{ number_format($sale->total_price, 0, ',', '.') }}</span>
        </div>
        <div class="text-sm text-gray-600">Metode Pembayaran: {{ ucfirst($sale->payment_method) }}</div>
    </div>

    <form id="delete-form-{{ $sale->id }}" action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="mt-4 w-full bg-black text-white py-2 rounded-md">Hapus Transaksi</button>
    </form>
</div>