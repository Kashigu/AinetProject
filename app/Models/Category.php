<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $table = 'categories';

    protected $fillable = ['name'];

    public $timestamps = false;



    public function tshirtImages():HasMany
    {
        return $this->hasMany(TshirtImage::class, 'category_id', 'id');
    }
}
