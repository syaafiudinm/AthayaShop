<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Sale;

/**
 * Class SaleDetailDelete
 *
 * Komponen Livewire ini bertanggung jawab untuk menampilkan detail transaksi penjualan
 * dalam sebuah modal dan menyediakan fungsionalitas untuk menghapus transaksi tersebut.
 * Komponen ini mendengarkan event untuk memicu penampilan modal dan akan memancarkan
 * event lain setelah penghapusan berhasil untuk memberitahu komponen lain.
 *
 * @package App\Livewire
 */
class SaleDetailDelete extends Component
{
    public $saleId = null;
    public $sale = null;
    public $showModal = false;

    /**
     * Mendefinisikan listener untuk event yang diterima oleh komponen ini.
     *
     * @var array
     */
    protected $listeners = ['showDetail'];

    /**
     * Menampilkan modal detail transaksi.
     * Metode ini dipicu oleh event 'showDetail' dan akan mengambil data transaksi
     * dari database berdasarkan ID yang diberikan.
     *
     * @param int $saleId ID dari transaksi penjualan yang akan ditampilkan.
     * @return void
     */
    public function showDetail($saleId)
    {
        $this->saleId = $saleId;
        $this->sale = Sale::with(['items.product', 'user'])->findOrFail($saleId);
        $this->showModal = true;
    }

    /**
     * Menutup modal dan mereset semua state properti komponen.
     *
     * @return void
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->sale = null;
        $this->saleId = null;
    }

    /**
     * Menghapus transaksi penjualan beserta item-item terkait.
     * Setelah berhasil menghapus, komponen akan memancarkan event 'saleDeleted'
     * dan menampilkan pesan sukses.
     *
     * @return void
     */
    public function deleteSale()
    {
        if (!$this->saleId) {
            session()->flash('error', 'Data transaksi tidak ditemukan.');
            return;
        }

        $sale = Sale::findOrFail($this->saleId);
        $sale->items()->delete(); // Hapus item-item terkait terlebih dahulu
        $sale->delete();

        $this->closeModal();

        $this->emit('saleDeleted'); // Memberi sinyal ke komponen lain untuk refresh
        session()->flash('success', 'Transaksi berhasil dihapus!');
    }

    /**
     * Merender view komponen Livewire.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.sale-detail-delete');
    }
}
