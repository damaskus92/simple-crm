<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
                'unique:employees,name,' . Auth::user()->id,
            ],
            'phone' => [
                'sometimes',
                'required',
                'string',
                'max:15',
                'unique:employees,phone,' . Auth::user()->id,
            ],
            'address' => [
                'nullable',
                'string',
            ],
        ];
    }
}
