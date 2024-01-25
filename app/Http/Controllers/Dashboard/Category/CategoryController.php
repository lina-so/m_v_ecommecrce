<?php
namespace App\Http\Controllers\Dashboard\Category;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;
use App\Services\SoftDeleteService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService,$softDeleteService;

    public function __construct(CategoryService $categoryService , SoftDeleteService $softDeleteService)
    {
        $this->categoryService = $categoryService;
        $this->softDeleteService = $softDeleteService;
    }

    /*****************************************************************************************************/

    public function index(Request $request)
    {
        $paginate = 'paginate';
        $categories = $this->categoryService->index($request,$paginate);
        return view('dashboard.categories.index',compact('categories'));
    }

    /*****************************************************************************************************/


    public function create(Request $request)
    {
        $paginate = false;
        $categoryParents = $this->categoryService->index($request,$paginate);
        $category = new Category;
        return view('dashboard.categories.create',compact('categoryParents','category'));
    }

    /*****************************************************************************************************/

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request);
        // dd($category);
          // افحص إذا كانت النتيجة رسالة خطأ
            if (is_string($category)) {
                return back()->with('customError', 'something wrong!'); // عرض الرسالة كخطأ
            }

            return redirect()->route('dashboard.categories.index')->with('success','category created!');
    }

    /*****************************************************************************************************/

    public function show(Category $category)
    {
        //
    }

    /*****************************************************************************************************/

    public function edit(string $id)
    {

        $category = Category::find($id);
        if(!$category)
        {
            return redirect()->route('dashboard.categories.index')->with('info','Record not found!');
        }

        // select * from category where id <> $id
        // and (parent_id is null or parent_id <> $id)
        $categoryParents = $this->categoryService->filterChildCategory($id);
        // dd($categoryParents);

        return view('dashboard.categories.edit',compact('category','categoryParents'));
    }

    /*****************************************************************************************************/

    public function update(StoreCategoryRequest $request, string $id)
    {
        $category = $this->categoryService->updateCategory($request,$id);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated!');
    }


    /*****************************************************************************************************/
    public function destroy(string $id)
    {
        $category = $this->categoryService->deleteCategory($id);
        return redirect()->route('dashboard.categories.index')->with('success','category deleted!');
    }

    /*****************************************************************************************************/
    public function trash(Request $request)
    {
        $paginate = 'trash';
        $categories = $this->categoryService->index($request,$paginate);
        return view('dashboard.categories.trash',compact('categories'));

    }

    /*****************************************************************************************************/
    public function restore($id)
    {
        $category = $this->softDeleteService->restore(Category::class, $id);
        return redirect()->route('dashboard.categories.trash')->with('success','category restored successfully !!');
    }

    /*****************************************************************************************************/
    public function forceDelete($id)
    {
        $category = $this->softDeleteService->forceDelete(Category::class,$id);
        return redirect()->route('dashboard.categories.trash')->with('success','category deleted successfully !!');
    }
     /*****************************************************************************************************/
     public function deleteAll(Request $request)
     {
         $categories = $this->categoryService->deleteAll($request);
         return redirect()->route('dashboard.categories.trash')->with('success','categories deleted successfully !!');
     }
     /*****************************************************************************************************/

    //  public function getSubcategories($id)
    //  {
    //     // $subCategories = $this->categoryService->getSubcategories($id);
    //     $subcategories = Category::where('parent_id', $id)->pluck('name', 'id');

    //     return $subcategories;
    //  }
    public function getSubcategories($id)
    {
        $subcategories = Category::where('parent_id', $id)->pluck('name', 'id');

        return response()->json($subcategories);
    }

}

