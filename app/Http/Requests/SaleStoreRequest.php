<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SaleStoreRequest extends FormRequest
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
        if ($this->delivery==1) {
            if ($this->method==1) {
                return [
                    'phone' => 'required|string|min:6|max:15',
                    'delivery' => 'required|'.Rule::in([1, 2]),
                    'state_id' => 'required',
                    'municipality_id' => 'required',
                    'location_id' => 'required',
                    'street' => 'required|string|min:1|max:191',
                    'house' => 'required|string|min:1|max:191',
                    'address' => 'nullable|string|min:2|max:191',
                    'method' => 'required|'.Rule::in([1, 2, 3]),
                    'reference' => 'required|string|min:2|max:191'
                ];
            } else {
                return [
                    'phone' => 'required|string|min:6|max:15',
                    'delivery' => 'required|'.Rule::in([1, 2]),
                    'state_id' => 'required',
                    'municipality_id' => 'required',
                    'location_id' => 'required',
                    'street' => 'required|string|min:1|max:191',
                    'house' => 'required|string|min:1|max:191',
                    'address' => 'nullable|string|min:2|max:191',
                    'method' => 'required|'.Rule::in([1, 2, 3])
                ];
            }
        } else {
            if ($this->method==1) {
                return [
                    'phone' => 'required|string|min:6|max:15',
                    'delivery' => 'required|'.Rule::in([1, 2]),
                    'state_id' => 'nullable',
                    'municipality_id' => 'nullable',
                    'location_id' => 'nullable',
                    'street' => 'nullable|string|min:1|max:191',
                    'house' => 'nullable|string|min:1|max:191',
                    'address' => 'nullable|string|min:2|max:191',
                    'method' => 'required|'.Rule::in([1, 2, 3]),
                    'reference' => 'required|string|min:2|max:191'
                ];
            } else {
                return [
                    'phone' => 'required|string|min:6|max:15',
                    'delivery' => 'required|'.Rule::in([1, 2]),
                    'state_id' => 'nullable',
                    'municipality_id' => 'nullable',
                    'location_id' => 'nullable',
                    'street' => 'nullable|string|min:1|max:191',
                    'house' => 'nullable|string|min:1|max:191',
                    'address' => 'nullable|string|min:2|max:191',
                    'method' => 'required|'.Rule::in([1, 2, 3])
                ];
            }
        }
    }
}
