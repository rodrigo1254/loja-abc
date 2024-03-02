<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name,','price','description'];

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function getPriceAttribute()
    {
        return $this->attributes['price'] / 100; // 2990 -> 29.90
    }

    public function setPriceAttribute($attr)
    {
        return $this->attributes['price'] = $attr * 100; //29.90 2990
    }
}
