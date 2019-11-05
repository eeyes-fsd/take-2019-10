<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'details' => 'required|array',
            'address_id' => 'required|int',
        ];
    }

    public function messages()
    {
        return [
            'details.required' => '内容不能为空',
            'address_id.required' => '地址不能为空',
        ];
    }
}
