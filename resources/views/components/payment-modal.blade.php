<div x-data="{ open: @entangle($attributes->wire('model')) }" x-show="open" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center">
    <div class="bg-white w-[700px] max-w-full p-6 rounded-xl flex justify-between shadow-xl relative">
        <!-- Close -->
        <button @click="open = false" class="absolute right-4 top-4 text-gray-600 hover:text-black text-xl">×</button>

        <!-- Kiri: Ringkasan -->
        <div class="w-1/2 pr-4">
            <h2 class="text-2xl font-bold mb-4">Pembayaran</h2>
            <div class="mb-4">
                <p class="text-sm text-gray-500">ID Transaksi</p>
                <p class="font-semibold">#{{ $sale->id ?? '00001' }}</p>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-500">Tanggal</p>
                <p class="font-semibold">{{ now()->format('l, d F Y') }}</p>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-500">Metode Pembayaran</p>
                <p class="font-semibold">{{ ucfirst($payment_method ?? 'Tunai') }}</p>
            </div>

            <!-- Detail Transaksi -->
            <div class="bg-blue-100 p-4 rounded-md">
                @foreach ($cart as $item)
                <div class="flex justify-between text-sm">
                    <span>{{ $item['name'] }}</span>
                    <span>{{ $item['total'] }}x</span>
                </div>
                <div class="flex justify-between font-semibold mb-2">
                    <span>Rp{{ number_format($item['unit_price'], 0, ',', '.') }}</span>
                </div>
                @endforeach

                <hr class="my-2 border-blue-300">
                <div class="flex justify-between text-sm">
                    <span>Subtotal</span>
                    <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm text-red-500">
                    <span>Discount</span>
                    <span>-Rp{{ number_format($discount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold mt-2">
                    <span>Total</span>
                    <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Kanan: Numpad -->
        <div class="w-1/2 pl-4">
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm text-gray-500">Nama Kasir</span>
                <span class="font-medium"><i class="fas fa-user mr-1"></i> {{ auth()->user()->name }}</span>
            </div>

            <div class="text-3xl font-bold text-center mb-4">
                Rp{{ number_format($cash_input ?? 0, 0, ',', '.') }}
            </div>

            <div class="grid grid-cols-3 gap-2 text-xl text-center">
                @foreach ([1,2,3,4,5,6,7,8,9,'.',0,'←'] as $btn)
                <button class="py-4 bg-gray-100 rounded hover:bg-gray-200" wire:click="press('{{ $btn }}')">
                    {{ $btn }}
                </button>
                @endforeach
            </div>

            <button wire:click="confirmPayment" class="mt-4 w-full bg-black text-white font-semibold py-3 rounded">Bayar</button>
        </div>
    </div>
</div>
