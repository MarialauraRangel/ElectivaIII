<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:191',
            'code' => 'required|string|min:2|max:191',
            'subcategory_id' => 'required|array',
            'color_id' => 'nullable|array',
            'size_id' => 'nullable|array',
            'qty' => 'required|integer|min:0',
            'price' => 'required|string|min:0',
            'discount' => 'required|integer|min:0|max:100',
            'description' => 'required|string|min:2|max:65000'
        ];
    }
}
