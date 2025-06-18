<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Absen
 *
 * Model ini merepresentasikan sebuah catatan absensi (kehadiran) untuk seorang pengguna.
 * Setiap record dalam tabel 'absens' terkait dengan satu pengguna (User).
 *
 * @package App\Models
 * @property int $id
 * @property int $user_id ID pengguna yang melakukan absensi.
 * @property string $tanggal Tanggal absensi.
 * @property string $check_in Waktu saat absensi dilakukan.
 * @property string $status Status kehadiran (e.g., 'Hadir', 'Sakit', 'Izin').
 * @property string|null $dokumen Path atau URL ke dokumen pendukung (jika ada).
 * @property string|null $approval_status Status persetujuan untuk absensi 'Sakit' atau 'Izin' (e.g., 'Pending', 'Approved', 'Rejected').
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\User $user Relasi ke model User.
 */
class Absen extends Model
{
    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'absens';  // pastikan sama nama tabel migrasi

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'check_in',
        'status',
        'dokumen',
        'approval_status',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Setiap catatan absensi dimiliki oleh satu pengguna.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
