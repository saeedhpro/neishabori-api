<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;

class CommentCreateRequest extends FormRequest
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
            'type' => 'required|string|in:' . Comment::TYPE_ARTICLE . ',' . Comment::TYPE_PRODUCT,
            'body' => 'required|string|min:3',
            'user_id' => 'required|exists:users,id',
            'parent_id' => 'required|exists:comments,id',
            'commentable_id' => 'required|numeric',
        ];
    }
}
