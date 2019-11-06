<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'password' => 'between:6,18'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '用户名不能为空',
            'phone.required' => '手机号码不能为空',
            'phone.regex' => '手机号码格式错误',
            'password.between' => '密码必须介于6-18个字符'
        ];
    }
}
