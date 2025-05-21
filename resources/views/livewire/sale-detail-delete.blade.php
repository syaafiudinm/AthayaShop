<div>
    @if ($showModal && $sale)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg max-w-lg w-full relative">
        <button wire:click="closeModal" class="absolute top-3 right-3 text-2xl font-bold">&times;</button>
        <h3 class="text-xl font-bold mb-4">Detail Order #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h3>
        <div class="mb-2">
          <strong>Kasir:</strong> {{ $sale->user->name }}<br>
          <strong>Tanggal:</strong> {{ $sale->created_at->format('l, d F Y') }}<br>
          <strong>Status:</strong> <span class="bg-blue-200 text-blue-700 px-2 rounded">{{ ucfirst($sale->status) }}</span>
        </div>
        <table class="w-full mb-4 text-sm">
          <thead>
            <tr class="border-b font-semibold">
              <th class="text-left">Barang</th>
              <th class="text-center">Qty</th>
              <th class="text-right">Harga</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($sale->items as $item)
            <tr>
              <td>{{ $item->product->name }}</td>
              <td class="text-center">{{ $item->total }}</td>
              <td class="text-right">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="flex justify-between font-bold text-lg mb-4">
          <span>Total Harga</span>
          <span>Rp{{ number_format($sale->total_price, 0, ',', '.') }}</span>
        </div>
        <div><strong>Metode Pembayaran:</strong> {{ ucfirst($sale->payment_method) }}</div>
        <div class="mt-6 flex gap-4">
          <button wire:click="deleteSale" class="flex-1 bg-red-600 text-white py-2 rounded hover:bg-red-700">Hapus Transaksi</button>
          <button wire:click="closeModal" class="flex-1 bg-gray-300 py-2 rounded hover:bg-gray-400">Tutup</button>
        </div>
      </div>
    </div>
    @endif
</div>
