<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponCreateRequest extends FormRequest
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
            'title' => 'required|string|min:1',
            'type' => 'required|in:fixed,percentage',
            'status' => 'required|in:enable,disable',
            'value' => 'required|string',
            'description' => 'nullable|string',
            'limit' => 'required|numeric',
            'expired_at' => 'nullable|string',
            'products' => 'array|min:0',
        ];
    }
}
