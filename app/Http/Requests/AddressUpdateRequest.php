<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required|string',
            'plate' => 'required|string',
            'uint' => 'required|string',
            'postal_code' => 'required|string',
            'recipient_first_name' => 'required|string',
            'recipient_last_name' => 'required|string',
            'recipient_phone_number' => 'required|string',
            'lat' => 'nullable|numeric',
            'long' => 'nullable|numeric',
            'city_id' => 'required|string',
        ];
    }
}
