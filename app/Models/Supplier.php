<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'name',
        'contact',
        'address'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
