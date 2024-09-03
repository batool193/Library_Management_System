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
class UserFormRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string|email|max:255|unique:users,email,',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:visitor,admin',
        ];
        // Adjust rules for PATCH or PUT requests
        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules = [
                'name' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'email' => 'nullable|string|email|max:255|exists:users,email',
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'nullable|string|string|in:visitor,admin',

            ];
        }

        return $rules;
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
            'unique' => ':attribute مسجل سابقا',
            'min' => 'يجب ان تحتوي :attribute على الاقل 8 محارف',
            'confirmed' => 'تأكيد :attribute غير مطابق',
            'regex' => ':attribute يجب ان يحوي حروف فقط'
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
            'name' => 'الاسم الكامل',
            'email' => 'عنوان البريد الالكتروني',
            'password' => 'كلمة السر',
            'role' => 'الدور'
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
            'errors' => $validator->errors(),
        ], 400));
    }
}
