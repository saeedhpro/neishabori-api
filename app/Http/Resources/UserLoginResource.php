<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLoginResource extends JsonResource
{
    private string $token;
    private User $user;

    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->user->id,
            'full_name' => $this->user->full_name,
            'phone_number' => $this->user->phone_number,
            'email' => $this->user->email,
            'sheba' => $this->user->sheba,
            'national_code' => $this->user->national_code,
            'job' => $this->user->job,
            'avatar' => $this->user->avatar,
            'is_legal' => $this->user->is_legal,
            'birth_date' => $this->user->birth_date,
            'organization' => $this->user->organization,
            'token' => $this->token,
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
        ];
    }
}
