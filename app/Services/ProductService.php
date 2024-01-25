<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Image;
use App\Models\Option;
use App\Models\Product;
use App\Models\OptionValue;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductService
{
/********************************************************************************************/

public function index(Request $request, $paginate = 'paginate')
{
    $filterFields = $request->only(['name']);

    $brandsQuery = Product::FilterByFields($filterFields,'brands');

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

    public function createProduct($requestData)
    {
        DB::beginTransaction();

        $request = $requestData->validated();

        $slug = Str::slug($request['name']);
        $request['slug']= $slug;

        try {
            $product = Product::create($request);

            // image store
            $time = Carbon::now();
            $format_time=$time->format('d-m-y').'_'.$time->format('H').'_'.$time->format('i').'_'.$time->format('m');

            if(Auth::guard('admin')->name == 'admin'){
                $filePath = 'admin' . '_' . $format_time;
            }
            else if(Auth::guard('vendor')->name == 'vendor')
            {
                $filePath = 'vendor'. '_' . $format_time;
            }


            if ($requestData->hasFile('image')) {
                foreach ($requestData->file('image') as $file) {
                    $path = $filePath;

                    $image = new Image(['path' => $path]);
                    $product->images()->save($image);

                    // Move the uploaded file to the desired location
                    // $file->storeAs('images', $path);
                 //or   // $file->move('images/'.$des,$image_name);
                }
            }

            // store options & values
            if(isset($request['options']))
            {
                foreach($request['options'] as $optionData)
                {
                    $option = Option::find($optionData['option_id']);
                    if($option)
                    {
                        foreach ($optionData['values'] as $valueData) {
                            $value = new OptionValue;
                            $value->option_id = $option->id;
                            $value->name = $valueData['value'];
                            $value->save();

                            $product->options()->attach($option->id, ['option_value_id' => $value->id]);
                        }

                    }
                }
            }
            DB::commit();
            return $product;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

        // Example in a controller method
        // $product = Product::find($productId);
        // $images = $product->images; // Retrieve associated images
    }


/********************************************************************************************/
    public function updateProduct($requestData, $brandId)
    {
        DB::beginTransaction();

        try {
            $requestData = $requestData->validated();
            $brand = Product::findOrFail($brandId);
            $brand->update($data);
            DB::commit();
            return $brand;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
/********************************************************************************************/

    public function deleteProduct($id)
    {
        $brand = Product::findOrFail($id);
        $brand->delete();
    }
/*********************************************************************************************/
    public function deleteAll(Request $request)
    {
        $delete_all_ids = explode(',',$request->delete_all_id);
        if($request->force)
            Product::whereIn('id',$delete_all_ids)->forceDelete();
        else
            Product::whereIn('id',$delete_all_ids)->delete();

    }
}

