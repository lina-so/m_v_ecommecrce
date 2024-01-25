<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;
class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id =$this->route('product');
        return [
        'name' => ["required", "string", "min:3", "max:255", Rule::unique('products','name')->ignore($id) ,
        ],
        'category_id' => 'required|numeric|exists:categories,id',
        'parent_id' => 'required|numeric|exists:categories,id',
        'brand_id' => 'required|numeric|exists:brands,id',
        'vendor_id' => 'required|numeric|exists:vendors,id',

        'quantity' => 'required|numeric',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'compare_price' => 'required|numeric',
        'status' => 'required|string|in:active,archived,draft',
        'featured' => 'required|string|in:0,1',
        // 'image' => ['required','image','mimes:png,jpg'],


        'image' => 'required',
        'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',

        'options' => 'required|array|min:1',
        'options.*.option_id' => 'required|numeric|exists:options,id',
        'options.*.values' => 'required|array|min:1',
        'options.*.values.*.value' => 'required|string|max:255',

        ];
    }
}
