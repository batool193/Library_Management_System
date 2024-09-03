<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class BorrowRecordFormRequest
 * 
 * This form request handles the validation logic for borrow record-related requests
 */
class BorrowRecordFormRequest extends FormRequest
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
        return [
            'due_date' => 'required|date|after_or_equal:borrowed_at|before_or_equal:returned_at',
            'borrowed_at' => 'required|date',
            'returned_at' => 'required|date',

        ];
    }
    /**
     * Get the custom messages for validator errors
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute مطلوب',
            'date' => 'يجب ان يكون :attribute تاريخا صالحا',
            'after_or_equal' => ':attribute يجب ان يكون بعد تاريخ الاستعارة',
            'before_or_equal' => ':attribute يجب ان يكون قبل تاريج الارجاع',

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
            'due_date' => 'تاريخ الاعادة',
        ];
    }
    /**
     * Handle a failed validation attempt
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
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
