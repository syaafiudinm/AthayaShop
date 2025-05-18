<?php

namespace App\Livewire;

use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;

class Kasir extends Component
{
    public $products = [], $categories = [], $suppliers = [];
    public $cart = [], $subtotal = 0, $discount = 20000, $total = 0;
    public $paymentMethod = 'qris';
    public $showModal = false;
    public $search, $category;

    public function mount()
    {
        $this->categories = Category::all();
        $this->suppliers = Supplier::all();
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

        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['total']++;
        } else {
            $this->cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'total' => 1,
                'unit_price' => $product->price,
            ];
        }

        $this->cart[$productId]['subtotal'] = $this->cart[$productId]['total'] * $this->cart[$productId]['unit_price'];
        $this->calculateTotal();
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
            session()->flash('error', 'Keranjang kosong. Tambahkan item terlebih dahulu.');
            $this->showModal = false;
            return;
        }
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'total_price' => $this->total,
            'payment_method' => $this->paymentMethod,
        ]);

        foreach ($this->cart as $item) {
            $sale->items()->create([
                'product_id' => $item['product_id'],
                'total' => $item['total'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        $this->reset(['cart', 'subtotal', 'total', 'paymentMethod', 'showModal']);
        session()->flash('success', 'Pembayaran berhasil!');
    }

    public function render()
    {
        return view('livewire.kasir');
    }
}
