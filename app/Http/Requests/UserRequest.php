<?php

namespace App\Http\Requests;

use Closure;
use App\Rules\FileRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;

class UserRequest extends FormRequest
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
            'email' => "required | email:rfc,dns | unique:users,email",
            'password' => "required | min:5",
            'full_name' => "required",
            'group_id' => "required",
            'phone_number' => "required",
            'img' => ["nullable",'mimes:jpeg,png','max:5120']
        ];
    }
    public function messages()
    {
        return [
            'email.required' => "Email must be required",
            'email.email' => "Email is not valid",
            'email.unique' => "Email must be unique",
            "password.required" => "Password must be required",
            "password.min" => "Password must be at least :min characters",
            "full_name" => "Password must be required",
            "group_id" => "Please select group of user",
            'img.mimes' => 'The :attribute must be a file of type: :values.',
            'img.max' => 'The :attribute may not be greater than :max kilobytes.'
        ];
    }
}
