<?php

namespace App\Models;

use App\Models\Product;
use App\Models\OptionValue;
use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory, FilterTrait , SoftDeletes;
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('product_option_value_id');
    }

    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

}
