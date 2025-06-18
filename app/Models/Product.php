<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * Model ini merepresentasikan sebuah produk yang tersedia untuk dijual.
 * Setiap produk terkait dengan satu kategori (Category) dan satu pemasok (Supplier),
 * dan dapat muncul di banyak item penjualan (SalesItem).
 *
 * @package App\Models
 * @property int $id
 * @property int $category_id ID kategori produk.
 * @property int $supplier_id ID pemasok produk.
 * @property string $name Nama produk.
 * @property string $description Deskripsi produk.
 * @property int $price Harga satuan produk.
 * @property int $stock Jumlah stok yang tersedia.
 * @property string|null $image Path atau URL ke gambar produk.
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Category $category Relasi ke model Category.
 * @property-read \App\Models\Supplier $supplier Relasi ke model Supplier.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesItem[] $salesItems Kumpulan item penjualan yang terkait dengan produk ini.
 */
class Product extends Model
{
    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category_id', // Sebaiknya ditambahkan di sini jika diisi melalui form
        'supplier_id', // Sebaiknya ditambahkan di sini jika diisi melalui form
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Category.
     * Setiap produk dimiliki oleh satu kategori.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Supplier.
     * Setiap produk dipasok oleh satu supplier.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model SalesItem.
     * Setiap produk bisa terdapat di banyak item penjualan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salesItems()
    {
        return $this->hasMany(SalesItem::class);
    }

}
