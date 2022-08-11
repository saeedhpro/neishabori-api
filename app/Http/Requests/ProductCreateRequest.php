<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var User $user */
        $user = auth()->user();
        return $user != null && $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3',
            'description' => 'required|string|min:3',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
            'is_special' => 'required|boolean',
            'special_price' => 'required|numeric|min:0',
            'special_start_date' => 'nullable|string',
            'special_end_date' => 'nullable|string',
            'attributes' => 'array|min:0',
            'images' => 'array|min:0|max:10',
            'images.*' => 'string',
            'related_products' => 'array|min:0|max:6',
            'related_products.*' => 'exists:products,id',
        ];
    }
}
