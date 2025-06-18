<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Sale
 *
 * Model ini merepresentasikan sebuah transaksi penjualan secara keseluruhan.
 * Setiap record penjualan terkait dengan satu pengguna (User) yang melakukan transaksi
 * dan memiliki banyak item penjualan (SalesItem).
 *
 * @package App\Models
 * @property int $id
 * @property string|null $order_id ID pesanan unik, terutama untuk gateway pembayaran seperti Midtrans.
 * @property int $user_id ID pengguna (kasir) yang menangani transaksi.
 * @property int $total_price Total harga akhir dari transaksi.
 * @property string $payment_method Metode pembayaran (e.g., 'cash', 'midtrans').
 * @property string $status Status transaksi (e.g., 'pending', 'paid', 'failed').
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user Relasi ke model User.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SalesItem[] $items Kumpulan item yang ada dalam transaksi ini.
 */
class Sale extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_price',
        'payment_method',
        'status',
        'order_id',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Setiap transaksi penjualan dilakukan oleh satu pengguna.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model SalesItem.
     * Setiap transaksi penjualan terdiri dari banyak item produk.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(SalesItem::class);
    }
}
