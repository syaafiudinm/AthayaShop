<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class SalesItem
 *
 * Model ini merepresentasikan satu item baris dalam sebuah transaksi penjualan.
 * Ini berfungsi sebagai tabel pivot antara model Sale dan Product dengan data tambahan
 * seperti jumlah, harga satuan, dan subtotal pada saat transaksi.
 *
 * @package App\Models
 * @property int $id
 * @property int $sale_id ID dari transaksi penjualan induk.
 * @property int $product_id ID dari produk yang dijual.
 * @property int $total Jumlah produk yang dibeli dalam item ini.
 * @property int $unit_price Harga satuan produk pada saat transaksi.
 * @property int $subtotal Total harga untuk item ini (total * unit_price).
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Sale $sale Relasi ke model Sale.
 * @property-read \App\Models\Product $product Relasi ke model Product.
 */
class SalesItem extends Model
{
    use HasFactory;

    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'sales_items';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sale_id', // Seharusnya 'sale_id' agar konsisten dengan nama metode relasi 'sale()'
        'product_id',
        'total',
        'unit_price',
        'subtotal',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Sale.
     * Setiap item penjualan dimiliki oleh satu transaksi penjualan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id'); // Eksplisitkan foreign key jika berbeda dari konvensi
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Product.
     * Setiap item penjualan merujuk ke satu produk.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
