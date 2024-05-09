<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariantRequest extends FormRequest
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
            'color_id'=>'required',
            'material_id'=>'required',
            'price'=>"required | integer",
            'qty_in_stock'=>"required | integer",
            'img' => ['required', 'mimes:jpeg,jpg,png,gif,mp4', 'max:5120']        ];
    }
    public function messages()
    {
        return [
            'color_id.required'=>'Please select color',
            'material_id.required' => 'Please select a material',
            'price.required' => 'Please enter a price.',
            'price.integer' => 'The price must be an integer.',
            'qty_in_stock.required' => 'Please enter a quantity.',
            'qty_in_stock.integer' => 'The quantity must be an integer.',
            'img.required' => 'Please select an image or video.',
            'img.mimes' => 'The image/video must be in JPEG, JPG, PNG, GIF, MP4 format.',
            'img.max' => 'The image/video may not be larger than 5MB.',
        ];
    }
}
