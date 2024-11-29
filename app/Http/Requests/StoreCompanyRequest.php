<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
                'required',
                'string',
                'unique:companies,name'
            ],
            'email' => [
                'required',
                'email',
                'unique:companies,email',
            ],
            'phone' => [
                'required',
                'string',
                'unique:companies,phone',
            ],
            'manager' => [
                'required',
                'array',
            ],
            'manager.name' => [
                'required',
                'string',
                'unique:employees,name',
                'unique:users,name',
            ],
            'manager.email' => [
                'required',
                'email',
                'unique:employees,email',
                'unique:users,email',
            ],
        ];
    }
}
