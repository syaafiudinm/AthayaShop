<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function salesItems()
    {
        return $this->hasMany(SalesItem::class);
    }

}
