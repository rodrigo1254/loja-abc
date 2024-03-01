<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleProduct extends Model
{
    use HasFactory,SoftDeletes;

    //protected $fillable = ['name,','price','description'];

    public function products()
    {
        return $this->hasMany(Product::class); //tem mts produtos
    }

    public function sales()
    {
        return $this->hasMany(Sale::class); //tem mts vendas
    }
}
