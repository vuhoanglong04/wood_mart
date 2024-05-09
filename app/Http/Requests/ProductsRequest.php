<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
        return [
            'product_name'=>"required | unique:products,product_name",
            'price'=>"required | integer",
            'category_id'=>"required",
            "product_description"=>"required",
            'product_theme' => ["required",'mimes:jpeg,png','max:5120']
        ];
    }
    public function messages(): array
    {
        return [
            'product_name.required' =>"Please enter product name",
            'product_name.unique' =>"Product name already exists",
            'price.required'=>"Please enter price",
            'price.integer'=>'Price must be a number',
            'category_id.required'=>"Please choose category",
            "product_description.required"=>"Please enter product description",
            'product_theme.required'=>"Please upload product theme",
            'product_theme.mimes' => 'The :attribute must be a file of type: :values.',
            'product_theme.max' => 'The :attribute may not be greater than :max kilobytes.'
        ];
    }

}
