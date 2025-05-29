<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    protected $table = 'absens';  // pastikan sama nama tabel migrasi

    protected $fillable = [
        'user_id',
        'tanggal',
        'check_in',
        'status',
        'dokumen', 
        'approval_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
