<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => 'required|max:20|min:3|unique:posts',
            'body' => 'required|max:1000|min:3|unique:posts', // dont use unique for title and body
            'picture' => 'required|image|unique:posts,picture',
            // 'category_id' => 'required|integer',
        ];
    }
}
