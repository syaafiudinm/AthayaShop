<div class="flex-1 p-4 md:p-8">
    <h1 class="text-3xl font-semibold mb-6">Kasir</h1>

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="category" class="border rounded-md p-2 w-full sm:w-auto">
                <option value="all">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('kasir') }}" class="flex items-center justify-center border p-2 rounded-md gap-2 whitespace-nowrap">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.15 3.36878C11.3254 3.48823 11.4461 3.67245 11.4856 3.88092C11.5252 4.08938 11.4803 4.30502 11.3608 4.48038C11.2413 4.65574 11.0571 4.77646 10.8487 4.816C10.6402 4.85553 10.4246 4.81063 10.2492 4.69118C9.51062 4.18909 8.62525 3.94861 7.73415 4.00805C6.84305 4.0675 5.99747 4.42345 5.33213 5.01919C4.66679 5.61494 4.21995 6.41621 4.06281 7.29536C3.90566 8.1745 4.04725 9.08096 4.46502 9.8703C4.88278 10.6596 5.55269 11.2865 6.36802 11.6509C7.18335 12.0154 8.0972 12.0965 8.96398 11.8814C9.83076 11.6662 10.6006 11.1672 11.1509 10.4638C11.7012 9.76039 12.0002 8.89306 12.0004 7.99998C12.0004 7.7878 12.0847 7.58432 12.2347 7.43429C12.3847 7.28426 12.5882 7.19998 12.8004 7.19998C13.0126 7.19998 13.2161 7.28426 13.3661 7.43429C13.5161 7.58432 13.6004 7.7878 13.6004 7.99998C13.6002 9.25037 13.1815 10.4647 12.4111 11.4496C11.6407 12.4344 10.5628 13.1331 9.34922 13.4342C8.13564 13.7354 6.85618 13.6218 5.71469 13.1114C4.57319 12.601 3.63534 11.7233 3.05056 10.6181C2.46578 9.51289 2.26772 8.24375 2.48792 7.0129C2.70813 5.78205 3.33394 4.66031 4.26564 3.82639C5.19734 2.99248 6.38134 2.49438 7.62897 2.41144C8.87661 2.32851 10.1161 2.66552 11.15 3.36878Z" fill="black" />
                    <path d="M10.8319 10.0048C10.7434 10.0614 10.6446 10.1 10.5412 10.1185C10.4377 10.1369 10.3317 10.1348 10.229 10.1123C10.1264 10.0897 10.0292 10.0472 9.94303 9.98707C9.85685 9.92697 9.78334 9.85048 9.72672 9.76197C9.67009 9.67346 9.63145 9.57466 9.61301 9.47122C9.59456 9.36777 9.59668 9.26171 9.61922 9.15908C9.64177 9.05646 9.68431 8.95927 9.74441 8.87309C9.80451 8.7869 9.88101 8.71339 9.96952 8.65677L12.7551 6.87517C12.9338 6.76457 13.1489 6.72874 13.3538 6.77541C13.5587 6.82208 13.737 6.94751 13.8502 7.12459C13.9634 7.30167 14.0023 7.51617 13.9586 7.72174C13.915 7.9273 13.7921 8.10742 13.6167 8.22317L10.8319 10.0048Z" fill="black" />
                    <path d="M15.123 9.92798C15.2047 10.1209 15.2074 10.3382 15.1306 10.5331C15.0538 10.728 14.9036 10.885 14.7123 10.9704C14.521 11.0558 14.3039 11.0627 14.1075 10.9897C13.9112 10.9167 13.7513 10.7696 13.6622 10.58L12.4558 7.87598C12.4106 7.77971 12.385 7.67539 12.3806 7.56913C12.3762 7.46286 12.393 7.35677 12.43 7.25708C12.4671 7.15738 12.5237 7.06608 12.5964 6.98851C12.6692 6.91094 12.7567 6.84865 12.8538 6.8053C12.9509 6.76195 13.0557 6.73841 13.1621 6.73604C13.2684 6.73367 13.3742 6.75253 13.4731 6.79152C13.5721 6.8305 13.6623 6.88883 13.7384 6.96308C13.8146 7.03734 13.8751 7.12604 13.9166 7.22398L15.123 9.92798Z" fill="black" />
                </svg>
                <span>Refresh</span>
            </a>
        </div>
        <div class="w-full md:w-80">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Cari nama produk..." class="border p-2 w-full rounded-md" />
        </div>
    </div>

    @include('components.alert')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
        <div class="lg:col-span-2 grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse ($products as $product)
                <div>
                    <div class="bg-white p-3 rounded-lg shadow border border-gray-200 flex flex-col">
                        <div class="relative rounded-md mb-3 overflow-hidden">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="object-cover w-full aspect-square rounded-md">
                            <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow-md border border-white/50">
                                Stok {{ $product->stock }}
                            </div>
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-bold text-md mb-1 line-clamp-2">{{ $product->name }}</h3>
                            <p class="font-semibold text-gray-800">
                                Rp{{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <button wire:click="addToCart({{ $product->id }})" class="mt-3 w-full bg-black hover:bg-gray-800 text-white py-2 rounded-md text-sm font-semibold transition-colors">
                            + Tambahkan
                        </button>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 py-10">Produk tidak ditemukan.</p>
            @endforelse
        </div>

        <div class="lg:sticky lg:top-8 self-start">
            <div class="bg-[#0077C0] text-white rounded-lg p-4 flex flex-col space-y-4">
                <div class="flex justify-between items-center pb-2 border-b border-white/20">
                    <h2 class="text-lg font-bold">Rangkuman Orderan</h2>
                    <span class="text-sm">Athaya Shop</span>
                </div>

                <div class="space-y-3 max-h-72 overflow-y-auto pr-2">
                    @forelse ($cart as $item)
                        <div class="bg-[#C7EEFF] text-black rounded-md p-2 flex items-center gap-3">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded-md bg-gray-300">
                            <div class="flex-1">
                                <p class="font-semibold text-sm line-clamp-1">{{ $item['name'] }}</p>
                                <p class="text-xs font-bold">({{ $item['total'] }}) x Rp{{ number_format($item['unit_price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="removeFromCart({{ $item['product_id'] }})" class="w-7 h-7 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded text-black font-bold transition-colors">-</button>
                                <button wire:click="addToCart({{ $item['product_id'] }})" class="w-7 h-7 flex items-center justify-center bg-gray-200 hover:bg-gray-300 rounded text-black font-bold transition-colors">+</button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-blue-200 py-8">Keranjang masih kosong.</p>
                    @endforelse
                </div>

                <div class="bg-[#C7EEFF] text-black p-3 rounded space-y-1 text-sm pt-4 border-t border-black/10">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-red-500">
                        <span>Diskon</span>
                        <span>-Rp{{ number_format($discount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-base pt-2 mt-2 border-t border-black/10">
                        <span>Total Harga</span>
                        <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <select wire:model="paymentMethod" class="text-black w-full rounded-md p-2 text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="midtrans">QRIS</option>
                    <option value="cash">Tunai</option>
                </select>

                <button wire:click="openModal" class="w-full bg-black hover:bg-gray-800 text-white py-2 rounded text-sm font-semibold transition-colors">Konfirmasi Pembayaran</button>
            </div>
        </div>
    </div>

    @if($showModal)
        <div class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 z-50 p-4">
            <div class="bg-white p-6 rounded-3xl shadow-xl w-full max-w-sm">
                <h3 class="text-lg font-bold mb-2">Konfirmasi Pembayaran</h3>
                <hr class="mb-4">
                <div class="space-y-1 text-gray-700">
                    <p>Total: <strong class="float-right text-black">Rp{{ number_format($total, 0, ',', '.') }}</strong></p>
                    <p>Metode: <strong class="float-right text-black">{{ ucfirst($paymentMethod) }}</strong></p>
                </div>
                <div class="mt-6 space-y-2">
                    <button wire:click="confirmPayment" class="w-full bg-[#0077C0] hover:bg-[#005f99] text-white p-2 rounded-lg transition-colors">Bayar</button>
                    <button wire:click="$set('showModal', false)" class="w-full bg-black hover:bg-gray-800 text-white p-2 rounded-lg transition-colors">Batal</button>
                </div>
            </div>
        </div>
    @endif
</div>
