<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !!auth()->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string|min:3',
            'phone_number' => 'required|string|min:3',
            'password' => 'nullable|string|min:6',
            'email' => 'nullable|string|min:3',
            'sheba' => 'nullable|string',
            'national_code' => 'nullable|string',
            'job' => 'nullable|string',
            'avatar' => 'nullable|string',
            'birth_date' => 'nullable|string',
        ];
    }
}
