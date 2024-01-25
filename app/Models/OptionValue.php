<?php

namespace App\Models;

use App\Traits\FilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OptionValue extends Model
{
    use HasFactory, FilterTrait , SoftDeletes;
    protected $fillable = ['name','option_id'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_option_values')->withPivot('product_option_value_id');
    }

}
