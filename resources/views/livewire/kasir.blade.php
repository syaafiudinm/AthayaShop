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

    <div class="mt-4">
        @include('components.alert')
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-4">
            @foreach ($products as $product)
            <div>
                <div class="p-4 rounded-lg shadow border border-gray-300 relative">
                    <div class="relative rounded-md mb-4 overflow-hidden">
                        <img src="{{ asset('Uploads/produk/thumb/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover rounded-md w-full h-48">
    
                        <!-- Stock Badge -->
                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow-xl border border-gray-300">
                            Stok {{ $product->stock }}
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-md mb-1">{{ $product->name }}</h3>
                        <p class="font-semibold">
                            Rp{{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <button wire:click="addToCart({{ $product->id }})" class="mt-4 w-full bg-black text-white py-2 rounded-md text-sm font-semibold">
                        + Tambahkan
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        <!-- Order Summary -->
        <div class="bg-[#0077C0] text-white rounded-lg p-4 space-y-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-bold">Rangkuman Orderan</h2>
                <span class="text-sm">Athaya Shop</span>
            </div>

            @foreach ($cart as $item)
                <div class="bg-[#C7EEFF] text-black rounded-md p-2 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gray-300 rounded">
                        <img src="{{ asset("Uploads/produk/thumb/".$item['image']) }}" alt="" class="w-full h-full object-cover rounded-md">
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm">{{ $item['name'] }} ({{ $item['total'] }})</p>
                        <p class="text-sm font-bold">Rp{{ number_format($item['unit_price'], 0, ',', '.') }}</p>
                    </div>
                    <div class="flex gap-1">
                        <button wire:click="removeFromCart({{ $item['product_id'] }})" class="px-2 bg-gray-200 rounded text-black">-</button>
                        <button wire:click="addToCart({{ $item['product_id'] }})" class="px-2 bg-gray-200 rounded text-black">+</button>
                    </div>
                </div>
            @endforeach

            <div class="bg-[#C7EEFF] text-black p-3 rounded space-y-1 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-red-500">
                    <span>Diskon</span>
                    <span>-Rp{{ number_format($discount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold text-base">
                    <span>Total Harga</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <select wire:model="paymentMethod" class="text-black w-full rounded-md p-2 text-sm">
                <option value="midtrans">Qris</option>
                <option value="cash">Tunai</option>
            </select>

            <button wire:click="openModal" class="w-full bg-black text-white py-2 rounded text-sm font-semibold">Konfirmasi Pembayaran</button>
        </div>
    </div>

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
