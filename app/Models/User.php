<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * Model ini merepresentasikan seorang pengguna dalam aplikasi. Ini adalah model
 * authenticatable yang digunakan oleh sistem otentikasi Laravel. Setiap pengguna
 * memiliki peran, dapat melakukan transaksi penjualan (Sale), dan memiliki catatan
 * kehadiran (Absen).
 *
 * @package App\Models
 * @property int $id
 * @property string $name Nama lengkap pengguna.
 * @property string $email Alamat email unik pengguna.
 * @property string $password Hash dari password pengguna.
 * @property string $role Peran pengguna dalam sistem (e.g., 'admin', 'cashier', 'owner').
 * @property string|null $qr_code Token unik yang digunakan untuk absensi via QR code.
 * @property string|null $remember_token Token untuk fitur "remember me".
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sale[] $sales Kumpulan transaksi penjualan yang dilakukan oleh pengguna ini.
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Absen[] $absens Kumpulan catatan kehadiran milik pengguna ini.
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications Notifikasi untuk pengguna.
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'qr_code',
        'role', // Sebaiknya ditambahkan jika diisi saat registrasi
    ];

    /**
     * Atribut yang harus disembunyikan saat di-serialisasi ke array atau JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Mendefinisikan relasi "hasMany" ke model Sale.
     * Setiap pengguna dapat memiliki banyak transaksi penjualan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model Absen.
     * Setiap pengguna dapat memiliki banyak catatan kehadiran.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absens()
    {
        return $this->hasMany(Absen::class);
    }

    /**
     * Membuat dan menyimpan token QR code untuk pengguna jika belum ada.
     *
     * Metode ini membuat hash unik berdasarkan ID dan email pengguna, menyimpannya
     * ke database, dan mengembalikannya. Jika token sudah ada, metode ini hanya
     * akan mengembalikan token yang ada.
     *
     * @return string Token QR code pengguna.
     */
    public function generateQrCode(){
        if(!$this->qr_code){
            $this->qr_code = hash('sha256', $this->id . $this->email . now()->toIso8601String());
            $this->save();
        }
        return $this->qr_code;
    }

}
