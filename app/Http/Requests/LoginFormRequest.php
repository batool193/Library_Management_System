<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class UserFormRequest
 *
 * This class handles the validation logic for user-related requests
 */
class LoginFormRequest extends FormRequest
{
    /**
     * Indicates if the validation should stop on the first failure
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules()
    {
        return  [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string',
        ];
    }
    /**
     * Get the custom validation messages
     *
     * @return array<string, string>
     */

    public function messages()
    {
        return [
            'required' => ' :attribute مطلوب',
            'string' => ':attribute يجب ان يكون نص',
            'email' => ':attribute يجب ان يكون صالحا',
            'exists' => ':attribute يجب ان يكون مسجل سابقا',
        ];
    }
    /**
     * Get custom attributes for validator errors
     *
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'email' => 'عنوان البريد الالكتروني',
            'password' => 'كلمة السر',
        ];
    }
    /**
     * Handle a failed validation attempt
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'خطأ في التحقق',
            'errors' => $validator->errors()
        ], 400));
    }
}
