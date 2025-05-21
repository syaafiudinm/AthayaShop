<div>
    <h4 class="fw-bold mb-3">Order #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h4>
    <p><strong>Kasir:</strong> {{ $sale->user->name }}</p>
    <p><strong>Tanggal:</strong> {{ $sale->created_at->format('l, d F Y') }}</p>
    <p><strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($sale->status) }}</span></p>

    <table class="table table-sm mt-4">
        <thead>
            <tr>
                <th>Barang</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-center">{{ $item->total }}</td>
                    <td class="text-end">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-between fw-bold fs-5 mt-4">
        <span>Total Harga</span>
        <span>Rp{{ number_format($sale->total_price, 0, ',', '.') }}</span>
    </div>

    <p class="mt-3"><strong>Metode Pembayaran:</strong> {{ ucfirst($sale->payment_method) }}</p>
</div>
