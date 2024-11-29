<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'company_id' => Auth::user()->profile->company->id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => [
                'required',
                'exists:companies,id',
            ],
            'name' => [
                'required',
                'string',
                'unique:employees,name',
            ],
            'email' => [
                'required',
                'email',
                'unique:employees,email',
            ],
            'phone' => [
                'required',
                'string',
                'max:15',
                'unique:employees,phone',
            ],
            'address' => [
                'nullable',
                'string',
            ],
        ];
    }
}
