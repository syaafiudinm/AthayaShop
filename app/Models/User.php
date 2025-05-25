<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'qr_code',  
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function absens()
    {
        return $this->hasMany(Absen::class);
    }
    
    public function generateQrCode(){
        if(!$this->qr_code){
            $this->qr_code = hash('sha256', $this->id . $this->email);
            $this->save();
        }
        return $this->qr_code;
    }

}
