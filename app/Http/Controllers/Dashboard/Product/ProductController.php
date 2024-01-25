<?php

namespace App\Http\Controllers\Dashboard\Product;

use App\Models\Option;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\BrandService;
use App\Services\ProductService;
use App\Services\CategoryService;
use App\Services\SoftDeleteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    protected $productService,$softDeleteService ,$brandService ,$categoryService;

    public function __construct(ProductService $productService ,BrandService $brandService, CategoryService $categoryService,SoftDeleteService $softDeleteService)
    {
        $this->productService = $productService;
        $this->softDeleteService = $softDeleteService;
        $this->brandService = $brandService;
        $this->categoryService = $categoryService;

    }

    /*****************************************************************************************************/

    public function index(Request $request)
    {
        $paginate = 'paginate';
        $products = $this->productService->index($request,$paginate);
        return view('dashboard.products.index',compact('products'));
    }

    /*****************************************************************************************************/


    public function create(Request $request)
    {
        $paginate = false;

        $product = new Product;
        $categories = $this->categoryService->index($request,$paginate);
        $brands = $this->brandService->index($request,$paginate);
        $vendors = Vendor::all();
        $options = Option::all();


        return view('dashboard.products.create',compact('product','categories','brands','vendors','options'));
    }

    /*****************************************************************************************************/

    public function store(StoreProductRequest $request)
    {
        // dd($request->validated());
        $product = $this->productService->createProduct($request);
           // افحص إذا كانت النتيجة رسالة خطأ
        //    dd($product);
        if (is_string($product)) {
            return back()->with('customError', 'Product creation failed: ' . $product);
        }
    

        return redirect()->route('dashboard.products.index')->with('success','product created!');
    }

    /*****************************************************************************************************/

    public function show(Category $product)
    {
        //
    }

    /*****************************************************************************************************/

    public function edit(string $id)
    {
        $product = Product::find($id);
        if(!$product)
        {
            return redirect()->route('dashboard.products.index')->with('info','Record not found!');
        }

        return view('dashboard.products.edit',[
            'product'=>$product,
        ]);
    }

    /*****************************************************************************************************/

    public function update(StoreProductRequest $request, string $id)
    {
        $product = $this->productService->updateProduct($request,$id);
        return redirect()->route('dashboard.products.index')->with('success', 'product updated!');
    }


    /*****************************************************************************************************/
    public function destroy(string $id)
    {
        $product = $this->productService->deleteProduct($id);
        return redirect()->route('dashboard.products.index')->with('success','product deleted!');
    }

    /*****************************************************************************************************/
    public function trash(Request $request)
    {
        $paginate = 'trash';
        $products = $this->productService->index($request,$paginate);
        return view('dashboard.products.trash',compact('products'));

    }

    /*****************************************************************************************************/
    public function restore($id)
    {
        $product = $this->softDeleteService->restore(Product::class,$id);
        return redirect()->route('dashboard.products.trash')->with('success','product restored successfully !!');
    }

    /*****************************************************************************************************/
    public function forceDelete($id)
    {
        $product = $this->softDeleteService->forceDelete(Product::class,$id);
        return redirect()->route('dashboard.products.trash')->with('success','product deleted successfully !!');
    }
     /*****************************************************************************************************/
     public function deleteAll(Request $request)
     {
         $products = $this->productService->deleteAll($request);
         return redirect()->route('dashboard.products.trash')->with('success','products deleted successfully !!');
     }
     /*****************************************************************************************************/

}

