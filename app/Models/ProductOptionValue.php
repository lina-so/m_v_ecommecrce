<?php

namespace App\Models;

use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductOptionValue extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','option_id','option_value_id'];
    
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

}
