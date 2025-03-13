<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string', 'min:0', 'max:255'],
            'gender' => ['required', 'integer', 'in:1,2'],
            'age_id' => ['required', 'integer', 'in:1,2,3,4,5,6'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'is_send_email' => ['string'],
            'feedback' => ['nullable', 'string', 'min:0', 'max:10000'],
        ];
    }
    /**
     * バリーデーションのためにデータを準備
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        if ($this->has('is_send_email')) {
            $this->merge([
                'is_send_email' => '1'
            ]);
        } else {
            $this->merge([
                'is_send_email' => '0'
            ]);
        }
    }
}
