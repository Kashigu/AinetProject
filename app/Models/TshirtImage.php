<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class TshirtImage extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    public $table = 'tshirt_images';
    protected $fillable = ['id', 'name', 'description'];


    protected function fullPhotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->image_url ? asset('storage/tshirt_images/' . $this->image_url) :
                    asset('/img/avatar_unknown.png');
            },
        );
    }
    protected function fullPhotoUrlPersona(): Attribute
    {
        return Attribute::make(
            get: function () {
                return ($this->customer_id ? route('tshirts.private',['tshirtImage'=>$this]) :
                    asset('storage/tshirt_images/' . $this->image_url));
            },
        );
    }

    public function orderItems():HasMany
    {
        return $this->hasMany(OrderItem::class,'tshirt_image_id','id');
    }

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function customer():HasOne
    {
        return $this->hasOne(Category::class, 'customer_id', 'id');
    }


}
