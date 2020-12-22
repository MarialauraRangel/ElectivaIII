<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileWebUpdateRequest extends FormRequest
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
    if ($this->password==NULL) {
      return [
        'photo' => 'nullable|file|mimetypes:image/*',
        'name' => 'required|string|min:2|max:191',
        'lastname' => 'required|string|min:2|max:191',
        'phone' => 'required|string|min:5|max:15',
        'state_id' => 'required',
        'municipality_id' => 'required',
        'location_id' => 'required',
        'street' => 'nullable|string|min:1|max:191',
        'house' => 'nullable|string|min:1|max:191',
        'address' => 'nullable|string|min:2|max:191',
      ];
    } else {
      return [
        'photo' => 'nullable|file|mimetypes:image/*',
        'name' => 'required|string|min:2|max:191',
        'lastname' => 'required|string|min:2|max:191',
        'phone' => 'required|string|min:5|max:15',
        'state_id' => 'required',
        'municipality_id' => 'required',
        'location_id' => 'required',
        'street' => 'nullable|string|min:1|max:191',
        'house' => 'nullable|string|min:1|max:191',
        'address' => 'nullable|string|min:2|max:191',
        'password' => 'required|string|min:8|confirmed'
      ];
    }
  }
}
