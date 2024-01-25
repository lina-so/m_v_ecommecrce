<?php

namespace App\Models;


use App\Traits\FilterTrait;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model  implements HasMedia
{
    use HasFactory , InteractsWithMedia, FilterTrait , SoftDeletes;

    protected $fillable = ['name','parent_id','description','status','slug'];

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id','id')->withDefault();
    }
    // protected static function boot()
    // {

    //     static::saving(function ($category) {
    //         $forbiddenNames = ['Gin', 'vodka', 'whiskey', 'wine', 'beer'];

    //         if (in_array(strtolower($category->name), $forbiddenNames)) {
    //             return false;
    //         }
    //     });
    // }

}
