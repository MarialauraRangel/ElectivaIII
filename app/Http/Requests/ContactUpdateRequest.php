<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactUpdateRequest extends FormRequest
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
            'banner' => 'nullable|file|mimetypes:image/*',
            'map' => 'nullable|string|min:50|max:1000',
            'phone' => 'nullable|string|min:5|max:20',
            'email' => 'nullable|string|email|max:191',
            'address' => 'nullable|string|min:2|max:191',
            'facebook' => 'nullable|string|min:2|max:191',
            'twitter' => 'nullable|string|min:2|max:191',
            'instagram' => 'nullable|string|min:2|max:191'
        ];
    }
}
