<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryService
{
/********************************************************************************************/

public function index(Request $request, $paginate = 'paginate')
{
    $filterFields = $request->only(['name', 'status']);
    $categoriesQuery = Category::leftJoin('categories as parents', 'parents.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name',
        ])->FilterByFields($filterFields,'categories');

    if ($paginate === 'paginate') {
        $categories = $categoriesQuery->paginate(6);

    }else if($paginate === 'trash')
    {
        $categories = $categoriesQuery->onlyTrashed()->paginate(5);
    }
    else {
        $categories = $categoriesQuery->get();
    }

    return $categories;
}

/********************************************************************************************/

    public function createCategory($requestData)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();

            $slug = Str::slug($data['name']);
            $data['slug'] = $slug;

            $category = Category::create($data);

            if ($requestData->hasFile('image')) {

                $category->addMediaFromRequest('image')
                ->withResponsiveImages([
                    'small' => [
                        'width' => 300,
                        'height' => 300,
                    ]
                ])
                ->toMediaCollection('images');

            }


            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }



// public function createCategory($requestData)
// {
//     DB::beginTransaction();

//     try {
//         $data = $requestData->validated();

//         $slug = Str::slug($data['name']);
//         $data['slug'] = $slug;

//         $category = Category::create($data);

//         $user = auth()->guard('admin')->user();

//         if ($requestData->hasFile('image')) {
//             $directory = 'categories/' . $user->name . '/' . $category->name;

//             if (!Storage::exists($directory)) {
//                 Storage::makeDirectory($directory);
//             }

//             // Get the uploaded file
//             $uploadedFile = $requestData->file('image');

//             // Store the file in the directory
//             $filePath = $directory . '/' . $uploadedFile->getClientOriginalName();
//             Storage::putFileAs($directory, $uploadedFile, $uploadedFile->getClientOriginalName());

//             // Add the file to the media library from the stored path
//            // Add the file to the media library without specifying the file path
//             $media = $category->addMedia($uploadedFile)->toMediaCollection('images');


//             // dd($media);
//         }

//         DB::commit();
//         return $category;
//     } catch (\Exception $e) {
//         DB::rollback();
//         return $e->getMessage();
//     }
// }


/********************************************************************************************/
    public function updateCategory($requestData, $categoryId)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();

            $category = Category::findOrFail($categoryId);

            $slug = Str::slug($data['name']);
            $data['slug'] = $slug;

            $category->update($data);

            if ($requestData->hasFile('image')) {
                if ($category->hasMedia('images')) {
                    $category->clearMediaCollection('images');
                }

                $category->addMediaFromRequest('image')->toMediaCollection('images');
            }

            DB::commit();
            return $category;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
/********************************************************************************************/

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        // if ($category->hasMedia('images')) {
        //     $category->clearMediaCollection('images');
        // }
    }
/*********************************************************************************************/
    public function filterChildCategory($id)
    {
        // select * from category where id <> $id
        // and (parent_id is null or parent_id <> $id)
        // $categoryParents = Category::where('id','<>',$id)
        //                             ->where(function($query) use ($id){
        //                                 $query->whereNull('parent_id')
        //                                       ->orWhere('parent_id','<>',$id);
        //                             })
        //                             ->pluck('id')->toArray();


        $categoryIds = collect([$id]);

        $childrenIds = Category::where('parent_id', $id)->pluck('id')->toArray();
        $categoryIds = collect($categoryIds)->merge($childrenIds);

        $indirectChildrenIds = Category::whereIn('parent_id', $childrenIds)->pluck('id')->toArray();
        $categoryIds = collect($categoryIds)->merge($indirectChildrenIds);

        // $categoryParents = Category::whereNotIn('id', $categoryIds)->pluck('id')->toArray();
        $categoryParents = Category::whereNotIn('id', $categoryIds)->get();


        return $categoryParents;
    }
    /**********************************************************************************/
    public function deleteAll(Request $request)
    {
        $delete_all_ids = explode(',',$request->delete_all_id);
        if($request->force)
            Category::whereIn('id',$delete_all_ids)->forceDelete();
        else
            Category::whereIn('id',$delete_all_ids)->delete();

    }
    /***************************************************************************************/
    public function getSubcategories($id)
    {
        $subcategories = Category::where('parent_id', $id)->pluck('name', 'id');

        return $subcategories;
    }
}

