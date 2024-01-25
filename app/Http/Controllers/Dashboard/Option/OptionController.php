<?php

namespace App\Http\Controllers\Dashboard\Option;

use App\Models\Option;
use Illuminate\Http\Request;
use App\Services\OptionService;
use App\Services\SoftDeleteService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOptionRequest;

class OptionController extends Controller
{
    protected $optionService,$softDeleteService;

    public function __construct(OptionService $optionService , SoftDeleteService $softDeleteService)
    {
        $this->optionService = $optionService;
        $this->softDeleteService = $softDeleteService;
    }
    /*****************************************************************************************************/

     public function index(Request $request)
    {
        $paginate = 'paginate';
        $options = $this->optionService->index($request,$paginate);
        return view('dashboard.options.index',compact('options'));
    }

    /*****************************************************************************************************/


    public function create(Request $request)
    {
        $option = new Option;
        return view('dashboard.options.create',compact('option'));
    }

    /*****************************************************************************************************/

    public function store(StoreOptionRequest $request)
    {
        $options = $this->optionService->createOption($request);
        return redirect()->route('dashboard.options.index')->with('success','options & values created!');

    }
    /*****************************************************************************************************/

    public function show(string $id)
    {
        //
    }
    /*****************************************************************************************************/
    public function edit(string $id)
    {
        $option = Option::findOrFail($id);
        if(!$option)
        {
            return redirect()->route('dashboard.options.index')->with('info','Record not found!');
        }

        return view('dashboard.options.edit',[
            'option'=>$option,
        ]);
    }

    /*****************************************************************************************************/

    public function update(StoreOptionRequest $request, string $id)
    {
        $option = $this->optionService->updateOption($request,$id);
        return redirect()->route('dashboard.options.index')->with('success', 'option updated!');
    }

    /*****************************************************************************************************/
    public function destroy(string $id)
    {
        $option = $this->optionService->deleteOption($id);
        return redirect()->route('dashboard.options.index')->with('success','option deleted!');
    }

    /*****************************************************************************************************/
    public function trash(Request $request)
    {
        $paginate = 'trash';
        $options = $this->optionService->index($request,$paginate);
        return view('dashboard.options.trash',compact('options'));

    }

    /*****************************************************************************************************/
    public function restore($id)
    {
        $option = $this->softDeleteService->restore(Option::class,$id);
        return redirect()->route('dashboard.options.trash')->with('success','option restored successfully !!');
    }

    /*****************************************************************************************************/
    public function forceDelete($id)
    {
        $option = $this->softDeleteService->forceDelete(Product::class,$id);
        return redirect()->route('dashboard.options.trash')->with('success','option deleted successfully !!');
    }
    /*****************************************************************************************************/
    public function deleteAll(Request $request)
    {
        $options = $this->optionService->deleteAll($request);
        return redirect()->route('dashboard.options.trash')->with('success','options deleted successfully !!');
    }
    /*****************************************************************************************************/
    public function getOptionValues($optionId){
        $optionValues = $this->optionService->getOptionValues($optionId);
        return $optionValues;
    }

}
