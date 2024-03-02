<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory,SoftDeletes;

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
        //return $this->belongsTo(SaleProduct::class);
    }

}
