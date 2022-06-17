<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CooperationRequestUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string',
            'phone_number' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string',
            'skill_id' => 'required|exists:skills,id',
            'city_id' => 'required|exists:cities,id',
        ];
    }
}
