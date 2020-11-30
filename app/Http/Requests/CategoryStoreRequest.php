<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryStoreRequest extends FormRequest
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
        $category=Category::where('slug', Str::slug($this->name))->withTrashed()->exists();
        ($category) ? $this->merge(['exist' => true]) : $this->merge(['exist' => false]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->exist) {
            $category=Category::where('slug', Str::slug($this->name))->withTrashed()->first();
            $category->restore();
        }
        return [
            'name' => 'required|string|min:2|max:191|unique:categories,name'
        ];
    }
}
