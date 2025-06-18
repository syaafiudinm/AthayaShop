<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 *
 * Model ini merepresentasikan data pemasok (supplier) atau vendor.
 * Setiap supplier dapat memasok banyak produk yang berbeda.
 *
 * @package App\Models
 * @property int $id
 * @property string $name Nama lengkap supplier.
 * @property string $contact Informasi kontak (telepon, email, dll).
 * @property string $address Alamat fisik supplier.
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products Kumpulan produk yang dipasok oleh supplier ini.
 */
class Supplier extends Model
{
    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'suppliers';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'contact',
        'address'
    ];

    /**
     * Mendefinisikan relasi "hasMany" ke model Product.
     * Setiap supplier dapat memasok banyak produk.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
