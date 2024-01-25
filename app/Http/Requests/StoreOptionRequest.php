<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOptionRequest extends FormRequest
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
        $id =$this->route('option');
        return [
            'option_name'=>['required','string','min:3','max:255',Rule::unique('options','name')->ignore($id)],
            'values' => 'required|array|min:1',
            'values.*.name' => ['required','string','min:3','max:255'],
    ];
    }
}
