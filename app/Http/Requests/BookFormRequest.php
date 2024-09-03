<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

/**
 * Class BookFormRequest
 * 
 * This form request handles the validation logic for book-related requests
 */
class BookFormRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure
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
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255|unique:books,title,',
            'author' => 'required|string|min:3|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'published_at' => 'required|date',
        ];
        // Adjust rules for PATCH or PUT requests
        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules = [
                'title' => 'nullable|string|max:255|unique:books,title,',
                'author' => 'nullable|string|min:3|max:255',
                'type' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
                'published_at' => 'nullable|date',
            ];
        }

        return $rules;
    }

    /**
     * Get the custom messages for validator errors
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ' :attribute مطلوب',
            'unique' => ':attribute موجود مسبقا',
            'min' => 'يجب أن يحتوي :attribute على أكثر من 3 حروف',
            'date' => 'يجب أن يكون :attribute تاريخًا صالحًا',
            'string' => ' :attribute يجب ان يكون نص',

        ];
    }
    /**
     * Get custom attributes for validator errors
     *
     * @return array
     */

    public function attributes()
    {
        return [
            'title' => 'عنوان الكتاب',
            'author' => 'مؤلف الكتاب',
            'type' => 'تصنيف الكتاب',
            'description' => 'وصف الكتاب',
            'published_at' => 'تاريخ النشر',
        ];
    }
    /**
     * Handle a failed validation attempt
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Validation\ValidationException
     */

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'message' => 'خطأ في التحقق',
            'errors' => $validator->errors()
        ], 400));
    }
}
