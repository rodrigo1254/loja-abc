<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleProduct extends Model
{
    use HasFactory,SoftDeletes;

    //protected $fillable = ['name,','price','description'];

    /*public function products()
    {
        return $this->hasMany(Product::class); //tem mts produtos
    }

    public function sales()
    {
        return $this->hasMany(Sale::class); //tem mts vendas
    }*/

    protected $fillable = ['name,','price','description'];

    public function sales()
    {
        return $this->belongsTo(Sale::class);
        //return $this->hasMany(Sale::class); 
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
        //return $this->hasMany(Product::class); 
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
