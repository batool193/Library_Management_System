<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


/**
 * Class RatingFormRequest
 *
 * This class handles the validation logic for rating requests
 */
class RatingFormRequest extends FormRequest
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
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
            'book_id' => 'required|integer|exists:books,id',
        ];
        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules = [
                'rating' => 'nullable|integer|min:1|max:5',
                'review' => 'nullable|string',
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
            'integer' => 'يجب أن يكون :attribute عددًا صحيحًا',
            'min' => 'يجب أن يكون :attribute 1 على الأقل',
            'max' => 'لا يجوز أن يكون :attribute أكبر من 5',
            'string' => 'يجب أن تكون :attribute عبارة عن نص ',
            'exists' => 'يجب ان تختار كتاب موجود',
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
            'rating' => 'التقييم',
            'review' => 'المراجعة',
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
            'success' => false,
            'message' => 'خطأ في التحقق',
            'errors' => $validator->errors()
        ], 422));
    }
}
