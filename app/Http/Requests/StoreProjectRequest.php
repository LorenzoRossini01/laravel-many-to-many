<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title"=>'required|string|max:150',
            "description"=>'required|string',
            "link"=>'required|url',
            "imageUrl"=>'nullable|image',
            'category_id'=>'required',
            'tags' => 'nullable|exists:tags,id',

        ];
    }
}
