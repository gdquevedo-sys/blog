<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $slug = request()->isMethod('put') ? 'required|unique:categories,slug' . $this->id : 'required|unique:categories';
        $image = request()->isMethod('put') ? 'nullable|image' : 'required|image';

        return [
            'name' => 'required|max:40',
            'slug' => $slug,
            'image' => $image,
            'is_featured' => 'required|boolean',
            'status' => 'required|boolean',
        ];
    }
}
