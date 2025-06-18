<?php

namespace App\Livewire;

use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Supplier;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Auth;

/**
 * Class Kasir
 *
 * Komponen Livewire ini berfungsi sebagai antarmuka Point of Sale (POS) yang lengkap.
 * Ini menangani penampilan produk, pemfilteran, pengelolaan keranjang belanja (cart),
 * perhitungan total, dan memproses pembayaran melalui dua metode: tunai (cash)
 * dan online (Midtrans).
 *
 * @package App\Livewire
 */

class Kasir extends Component
{
    public $products = [], $categories = [], $suppliers = [];
    public $cart = [], $subtotal = 0, $discount = 20000, $total = 0;
    public $paymentMethod = 'cash';
    public $showModal = false;
    public $search, $category;

    public function mount()
    {
        $this->categories = Category::all();
        $this->suppliers = Supplier::all();
        $this->cart = session()->get('kasir_cart', []);
        $this->calculateTotal();
        $this->loadProducts();
    }

    public function updatedSearch() { $this->loadProducts(); }
    public function updatedCategory() { $this->loadProducts(); }

    public function loadProducts()
    {
        $this->products = Product::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->category && $this->category !== 'all', fn($q) => $q->where('category_id', $this->category))
            ->get();
    }

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

        // Get the current quantity in the cart for this product
        $quantityInCart = isset($this->cart[$productId]['total']) ? $this->cart[$productId]['total'] : 0;

        // Check if adding another item would exceed the available stock
        if ($product->stock <= $quantityInCart) {
            // Flash an error message and stop the function
            session()->flash('error', 'Stok untuk produk "' . $product->name . '" tidak mencukupi.');
            return;
        }

        // If stock is sufficient, proceed to add to cart
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['total']++;
        } else {
            $this->cart[$productId] = [
                'product_id' => $product->id,
                'name'       => $product->name,
                'image'      => $product->image,
                'total'      => 1,
                'unit_price' => $product->price,
            ];
        }

        $this->cart[$productId]['subtotal'] = $this->cart[$productId]['total'] * $this->cart[$productId]['unit_price'];
        $this->calculateTotal();
        session(['kasir_cart' => $this->cart]);
    }

    public function removeFromCart($productId)
    {
        if (!isset($this->cart[$productId])) return;

        $this->cart[$productId]['total']--;

        if ($this->cart[$productId]['total'] <= 0) {
            unset($this->cart[$productId]);
        } else {
            $this->cart[$productId]['subtotal'] = $this->cart[$productId]['total'] * $this->cart[$productId]['unit_price'];
        }

        $this->calculateTotal();
        session(['kasir_cart' => $this->cart]);
    }

    public function calculateTotal()
    {
        $this->subtotal = collect($this->cart)->sum('subtotal');
        $this->total = max(0, $this->subtotal - $this->discount);
    }

    public function openModal() { $this->showModal = true; }

    public function confirmPayment()
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang kosong!');
            return;
        }

        if ($this->paymentMethod === 'cash') {
            // Proses pembayaran tunai langsung simpan
            $this->processCashPayment();
        } elseif ($this->paymentMethod === 'midtrans') {
            // Proses pembayaran via Midtrans
            return $this->processMidtransPayment();
        }
    }

    protected function processCashPayment()
    {
        // Simpan data pembayaran tunai langsung paid
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_price' => $this->total,
            'payment_method' => 'cash',
            'status' => 'paid',
        ]);

        foreach ($this->cart as $item) {
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'total' => $item['total'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);

            $product = Product::find($item['product_id']);
            if ($product) {
                $product->decrement('stock', $item['total']);
            }
        }

        $this->resetCart();
        session()->flash('success', 'Pembayaran tunai berhasil!');
    }


    protected function processMidtransPayment()
    {
        // `status` akan otomatis 'pending' karena sudah diatur di migrasi
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_price' => $this->total,
            'payment_method' => 'midtrans',
        ]);

        // Buat Sale Items (kode Anda sudah benar)
        foreach($this->cart as $item){
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'total' => $item['total'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Buat order_id yang unik
        $orderId = 'ATHAYA-' . $sale->id . '-' . time();

        // Simpan order_id ke database (SANGAT PENTING)
        $sale->update(['order_id' => $orderId]);

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $this->total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' => ['gopay'],
            'callsback' => [
                'finish' => route('sales.index')
            ]
        ];
        // Redirect URL setelah pembayaran selesai (opsional)
        // Pastikan route 'sales.index' ada dan bisa diakses

        $midtrans = new MidtransService();
        $snap = $midtrans->createTransaction($payload);

        $this->resetCart();
        return redirect($snap->redirect_url);
    }

    protected function resetCart()
    {
        $this->reset(['cart', 'subtotal', 'total', 'paymentMethod', 'showModal']);
        session()->forget('kasir_cart');
    }


    public function render()
    {
        return view('livewire.kasir');
    }
}
