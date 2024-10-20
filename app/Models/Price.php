<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $fillable = ["unit_price_catalog", "unit_price_own", "unit_price_catalog_discount", "unit_price_own_discount", "qty_discount"];

    public $timestamps = false;

    public function getPrice()
    {
        return Price::all();
    }
}
