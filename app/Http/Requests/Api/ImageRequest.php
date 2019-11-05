<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
        $rules = [
            'type' => 'required|string|in:avatar,commodity'
        ];

        if ($this->type === 'avatar')
        {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200';
        } elseif ($this->type === 'commodity') {
            $rules['image'] = 'required|mimes:jpeg,bmp,png,gif';
        }

        return  $rules;
    }

    public function messages()
    {
        return [
            'image.dimension' => '图片清晰度不足，最小需要 200×200'
        ];
    }
}
