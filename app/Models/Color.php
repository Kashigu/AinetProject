<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['code', 'name'];

    protected $primaryKey ='code';

    public $incrementing =false;
    public $timestamps = false;



        protected function tshirtFoto(): Attribute
        {
            return Attribute::make(
                get: function () {
                    return $this->code ? asset('storage/tshirt_base/' . $this->code . '.jpg') :
                        asset('storage/tshirt_base/fafafa.jpg');
                },
            );
        }

    public function orderItems():HasMany{
        return $this->hasMany(OrderItem::class,'color_code','code');
    }

}
