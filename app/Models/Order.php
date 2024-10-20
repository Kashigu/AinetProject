<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Order extends Model
{
    use HasFactory;
    protected $fillable=['status','customer_id','date','total_price','notes','nif','address','payment_type','payment_ref','receipt_url'];

    public function customer():BelongsTo{
        return $this->belongsTo(Customer::class)->withThrashed();
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class)->withThrashed();
    }
}
