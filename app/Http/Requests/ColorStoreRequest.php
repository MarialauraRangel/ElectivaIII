<?php

namespace App\Http\Requests;

use App\Color;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ColorStoreRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $trashed=Color::where('slug', Str::slug($this->name))->withTrashed()->exists();
        $exist=Color::where('slug', Str::slug($this->name))->exists();
        ($trashed) ? $this->merge(['trashed' => true]) : $this->merge(['trashed' => false]);
        ($exist) ? $this->merge(['exist' => true]) : $this->merge(['exist' => false]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->trashed && $this->exist===false) {
            $color=Color::where('slug', Str::slug($this->name))->withTrashed()->first();
            $color->restore();
        }
        return [
            'name' => 'required|string|min:2|max:191|unique:colors,name',
            'color' => 'required'
        ];
    }
}
