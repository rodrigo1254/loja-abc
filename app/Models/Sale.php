<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'status'
    ];

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }

    public function saleCancels()
    {
        return $this->hasMany(SaleCancel::class);
    }

}
