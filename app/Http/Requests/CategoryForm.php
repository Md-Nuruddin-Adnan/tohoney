<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FindOutNumberRule;

class CategoryForm extends FormRequest
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
            'category_name' => ['required', 'unique:categories,category_name', new FindOutNumberRule],
            'category_description' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'category_name.required' => 'Category name koi?',
            'category_description.required' => 'Category description koi?',
        ];
    }
}
