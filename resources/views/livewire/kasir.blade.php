<div class="flex-1 p-8">
    <h1 class="text-3xl font-semibold mb-4">Kasir</h1>
    <div class="flex justify-between">
        <div class="w-fit">
            <select wire:model="category" class="border rounded-md p-2 mb-4 w-full">
                <option value="all">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-80">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Cari..." class="border p-2 mb-4 w-full rounded-md" />
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach ($products as $product)
            <div class="border p-2 rounded">
                <p class="font-semibold">{{ $product->name }}</p>
                <p>Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <button wire:click="addToCart({{ $product->id }})" class="mt-2 px-2 py-1 bg-black text-white rounded">+</button>
            </div>
        @endforeach
    </div>

    <hr class="my-6" />

    <h2 class="text-xl font-bold mb-4">Order Summary</h2>
    @foreach ($cart as $item)
        <div class="flex justify-between items-center border p-2 mb-2">
            <span>{{ $item['name'] }} x{{ $item['total'] }}</span>
            <div>
                <button wire:click="removeFromCart({{ $item['product_id'] }})" class="px-2">-</button>
                <button wire:click="addToCart({{ $item['product_id'] }})" class="px-2">+</button>
            </div>
        </div>
    @endforeach

    <p class="font-semibold">Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
    <p class="text-red-500">Diskon: Rp{{ number_format($discount, 0, ',', '.') }}</p>
    <p class="font-bold text-lg">Total: Rp{{ number_format($total, 0, ',', '.') }}</p>

    <select wire:model="paymentMethod" class="w-full mt-4 p-2 border">
        <option value="qris">Qris</option>
        <option value="cash">Tunai</option>
        <option value="transfer">Transfer</option>
    </select>

    <button wire:click="openModal" class="mt-4 w-full bg-blue-600 text-white p-2 rounded">Konfirmasi Pembayaran</button>

    @if($showModal)
        <div class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 rounded shadow w-full max-w-md">
                <h3 class="text-lg font-bold mb-2">Konfirmasi Pembayaran</h3>
                <p>Total: <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></p>
                <p>Metode: <strong>{{ ucfirst($paymentMethod) }}</strong></p>
                <button wire:click="confirmPayment" class="mt-4 w-full bg-green-600 text-white p-2 rounded">Bayar</button>
                <button wire:click="$set('showModal', false)" class="mt-2 w-full bg-gray-300 text-black p-2 rounded">Batal</button>
            </div>
        </div>
    @endif
</div>
