<?php

namespace App\Http\Controllers\Dashboard\Brand;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Services\BrandService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;

use App\Services\SoftDeleteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    protected $brandService,$softDeleteService;

    public function __construct(BrandService $brandService , SoftDeleteService $softDeleteService)
    {
        $this->brandService = $brandService;
        $this->softDeleteService = $softDeleteService;
    }

    /*****************************************************************************************************/

    public function index(Request $request)
    {
        $paginate = 'paginate';
        $brands = $this->brandService->index($request,$paginate);
        return view('dashboard.brands.index',compact('brands'));
    }

    /*****************************************************************************************************/


    public function create(Request $request)
    {
        $brand = new Brand;
        return view('dashboard.brands.create',compact('brand'));
    }

    /*****************************************************************************************************/

    public function store(StoreBrandRequest $request)
    {
        $brand = $this->brandService->createBrand($request);
          // افحص إذا كانت النتيجة رسالة خطأ
            // if (is_string($brand)) {
            //     return back()->with('customError', 'something wrong!');
            // }

            return redirect()->route('dashboard.brands.index')->with('success','brand created!');
    }

    /*****************************************************************************************************/

    public function show(Category $brand)
    {
        //
    }

    /*****************************************************************************************************/

    public function edit(string $id)
    {
        $brand = Brand::find($id);
        if(!$brand)
        {
            return redirect()->route('dashboard.brands.index')->with('info','Record not found!');
        }

        return view('dashboard.brands.edit',[
            'brand'=>$brand,
        ]);
    }

    /*****************************************************************************************************/

    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand = $this->brandService->updateBrand($request,$id);
        return redirect()->route('dashboard.brands.index')->with('success', 'brand updated!');
    }


    /*****************************************************************************************************/
    public function destroy(string $id)
    {
        $brand = $this->brandService->deleteBrand($id);
        return redirect()->route('dashboard.brands.index')->with('success','brand deleted!');
    }

    /*****************************************************************************************************/
    public function trash(Request $request)
    {
        $paginate = 'trash';
        $brands = $this->brandService->index($request,$paginate);
        return view('dashboard.brands.trash',compact('brands'));

    }

    /*****************************************************************************************************/
    public function restore($id)
    {
        $brand = $this->softDeleteService->restore(Brand::class,$id);
        return redirect()->route('dashboard.brands.trash')->with('success','brand restored successfully !!');
    }

    /*****************************************************************************************************/
    public function forceDelete($id)
    {
        $brand = $this->softDeleteService->forceDelete(Brand::class,$id);
        return redirect()->route('dashboard.brands.trash')->with('success','brand deleted successfully !!');
    }
     /*****************************************************************************************************/
     public function deleteAll(Request $request)
     {
         $brands = $this->brandService->deleteAll($request);
         return redirect()->route('dashboard.brands.trash')->with('success','brands deleted successfully !!');
     }
     /*****************************************************************************************************/

}
