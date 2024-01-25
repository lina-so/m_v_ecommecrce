<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Option;
use App\Models\Product;
use App\Models\OptionValue;
use App\Traits\FilterTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model  implements HasMedia
{
    use HasFactory ,FilterTrait , SoftDeletes,InteractsWithMedia;
    protected $fillable = ['brand_id','vendor_id','category_id','name','quantity',
    'slug','description','price','compare_price','status','featured','code'];


    // product code generate
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->code = 'PRD' . substr(strtoupper($product->name), 0, 4) . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        });
    }

    // brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    // option
    public function options()
    {
        return $this->belongsToMany(Option::class, 'product_option_values')->withPivot('option_value_id');
    }

    // optionValues
    public function optionValues()
    {
        return $this->belongsToMany(OptionValue::class, 'product_option_values')->withPivot('option_id');
    }

    // images
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }





}
