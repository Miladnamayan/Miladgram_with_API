<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            // 'email' => 'required|email|max:255|unique:Users,email',
            // 'email' => [
            //     'required',
            //     'email',
            //     'max:255',
            //     Rule::unique('users')->ignore($this->id),
            // ],
            'email' => 'required|email|max:255|',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'string|min:4|max:20',
            'password' => 'required|min:8',
            'confirm_password'=> 'required|same:password',
        ];
    }
}
