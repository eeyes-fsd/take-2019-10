<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'name' => 'required',
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/'
            ],
            'gender' => 'required|in:m,f,s',
            'details' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '缺少姓名',
            'phone.required' => '缺少手机号码',
            'phone.regex' => '手机号码格式错误',
            'gender.required' => '缺少性别',
            'gender.in' => '性别格式错误',
            'details.required' => '缺少具体信息',
        ];
    }
}
