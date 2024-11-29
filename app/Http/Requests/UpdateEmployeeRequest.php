<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            'name' => [
                'sometimes',
                'required',
                'string',
                'unique:employees,name,' . $this->employee->id,
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'unique:employees,email,' . $this->employee->id,
            ],
            'phone' => [
                'sometimes',
                'required',
                'string',
                'max:15',
                'unique:employees,phone,' . $this->employee->id,
            ],
            'address' => [
                'nullable',
                'string',
            ],
        ];
    }
}
