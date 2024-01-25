<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SoftDeleteService
{
/********************************************************************************************/

    public function restore($modelName,$id)
    {
        $modelClass = $modelName;
        $item = $modelClass::onlyTrashed()->findOrFail($id);

        $item->restore();
    }

/********************************************************************************************/

    public function forceDelete($modelName,$id)
    {
        $item = $modelName::onlyTrashed()->findOrFail($id);
        $item->forceDelete();
        
        if (method_exists($item, 'hasMedia') && method_exists($item, 'clearMediaCollection')) {
            if ($item->hasMedia('images')) {
                $item->clearMediaCollection('images');
            }
        }
    }

}

