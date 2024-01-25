<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BrandService
{
/********************************************************************************************/

public function index(Request $request, $paginate = 'paginate')
{
    $filterFields = $request->only(['name']);

    $brandsQuery = Brand::FilterByFields($filterFields,'brands');

    if ($paginate === 'paginate') {
        $brands = $brandsQuery->paginate(6);

    }else if($paginate === 'trash')
    {
        $brands = $brandsQuery->onlyTrashed()->paginate(5);
    }
    else {
        $brands = $brandsQuery->get();
    }

    return $brands;
}

/********************************************************************************************/

    public function createBrand($requestData)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();
            foreach($data['name'] as $name)
            {
                $brands = Brand::create(['name' => $name]);
            }

            DB::commit();
            return $brands;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }


/********************************************************************************************/
    public function updateBrand($requestData, $brandId)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();
            $brand = Brand::findOrFail($brandId);
            $brand->update($data);
            DB::commit();
            return $brand;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
/********************************************************************************************/

    public function deleteBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
    }
/*********************************************************************************************/
    public function deleteAll(Request $request)
    {
        $delete_all_ids = explode(',',$request->delete_all_id);
        if($request->force)
            Brand::whereIn('id',$delete_all_ids)->forceDelete();
        else
            Brand::whereIn('id',$delete_all_ids)->delete();

    }
}

