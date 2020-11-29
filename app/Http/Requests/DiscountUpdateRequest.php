<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DiscountUpdateRequest extends FormRequest
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
        if ($this->type==1) {
            return [
                'type' => 'required|'.Rule::in([1, 2]),
                'discount' => 'required|integer|min:0|max:100'
            ];
        } else {
            return [
                'type' => 'required|'.Rule::in([1, 2]),
                'category_id' => 'required',
                'category_discount' => 'required|integer|min:0|max:100',
            ];
        }
    }
}
