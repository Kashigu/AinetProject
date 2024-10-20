<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;
    public $table = 'order_items';
    public $timestamps = false;

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_code', 'code');
    }

    public function tshirtImage(): BelongsTo
    {
        return $this->belongsTo(TshirtImage::class, 'tshirt_image_id', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

}
