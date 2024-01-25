<?php

namespace App\Http\Requests;

use App\Rules\ExceptNameRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return Auth::check() && Auth::user()->email_verified_at !== null ;
        // هل اليوز مسجل دخول وعامل تاكيد لايميله
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        $id =$this->route('category');
        return [
        'name' => ["required", "string", "min:3", "max:50", Rule::unique('categories','name')->ignore($id) ,
        new ExceptNameRule()
        // 'filter:beer,html'
        ],
       'parent_id' => ['nullable','int', 'exists:categories,id'],
       'image' => ['image', 'mimes:png,jpg,jpeg'],
       'description' => ['nullable','string'],
       'status' => ['in:active,archived'],


        ];
    }
}
