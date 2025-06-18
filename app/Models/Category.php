<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 *
 * Model ini merepresentasikan sebuah kategori untuk produk. Setiap kategori dapat
 * memiliki banyak produk yang terkait dengannya.
 *
 * @package App\Models
 * @property int $id
 * @property string $name Nama kategori.
 * @property string $description Deskripsi singkat mengenai kategori.
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products Kumpulan produk yang masuk dalam kategori ini.
 */
class Category extends Model
{
    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Mendefinisikan relasi "hasMany" ke model Product.
     * Setiap kategori dapat memiliki banyak produk.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
