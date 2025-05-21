<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;

class SaleDetailDelete extends Component
{
    public $saleId = null;
    public $sale = null;
    public $showModal = false;

    protected $listeners = ['showDetail'];

    public function showDetail($saleId)
    {
        $this->saleId = $saleId;
        $this->sale = Sale::with(['items.product', 'user'])->findOrFail($saleId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->sale = null;
        $this->saleId = null;
    }

    public function deleteSale()
    {
        if (!$this->saleId) {
            session()->flash('error', 'Data transaksi tidak ditemukan.');
            return;
        }

        $sale = Sale::findOrFail($this->saleId);
        $sale->items()->delete();
        $sale->delete();

        $this->closeModal();

        $this->emit('saleDeleted'); // supaya parent/halaman bisa refresh atau kasih notif
        session()->flash('success', 'Transaksi berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.sale-detail-delete');
    }
}
