<?php

namespace App\Services;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OptionService
{
/********************************************************************************************/

public function index(Request $request, $paginate = 'paginate')
{
    $filterFields = $request->only(['name']);

    $optionsQuery = Option::FilterByFields($filterFields,'options');

    if ($paginate === 'paginate') {
        $options = $optionsQuery->paginate(6);

    }else if($paginate === 'trash')
    {
        $options = $optionsQuery->onlyTrashed()->paginate(5);
    }
    else {
        $options = $optionsQuery->get();
    }

    return $options;
}

/********************************************************************************************/

    public function createOption($requestData)
    {
        DB::beginTransaction();

        try {
            $data = $requestData->validated();

            if(isset($data['options']))
            {
                foreach($data['options'] as $optionData)
                {
                    $option = Option::create(['name'=> $optionData['option_name']]);
                    foreach($optionData['values'] as $valueData)
                    {
                        $value = new OptionValue;
                        $value->option_id = $option->id;
                        $value->name = $valueData['value'];
                        $value->save();
                    }

                }

            }

            DB::commit();
            return $value;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

/********************************************************************************************/

public function updateOption($requestData, $optionId)
{
    DB::beginTransaction();

    try {
        $data = $requestData->validated();
        $option = Option::findOrFail($optionId);

        if (isset($data['option_name'])) {
            $option->name = $data['option_name'];
            $option->save();
        }

        // إزالة القيم القديمة التي لم يتم إرسالها في البيانات
        if (isset($data['values'])) {
            $newValues = collect($data['values'])->pluck('name')->all();
            $option->values()->whereNotIn('name', $newValues)->delete();
        }

        // إضافة القيم الجديدة أو تحديث القيم القديمة
        foreach ($data['values'] as $valueData) {
            $value = OptionValue::updateOrCreate(
                ['option_id' => $optionId, 'name' => $valueData['name']],
                ['name' => $valueData['name']]
            );
        }

        DB::commit();
        return $option;

    } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
    }
}


/********************************************************************************************/

    public function deleteOption($id)
    {
        $option = Option::findOrFail($id);
        $option->delete();
    }
/*********************************************************************************************/
    public function deleteAll(Request $request)
    {
        $delete_all_ids = explode(',',$request->delete_all_id);
        if($request->force)
            Option::whereIn('id',$delete_all_ids)->forceDelete();
        else
            Option::whereIn('id',$delete_all_ids)->delete();

    }

/**********************************************************************************************/
    public function getOptionValues($optionId)
    {
        $optionValues = OptionValue::where('option_id',$optionId)->pluck('name','id');
        return response()->json($optionValues);

    }

}

