<?php


namespace App\Repositories;


use App\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    function findOneByPhoneNumberOrFail(string $phone_number)
    {
        return $this->model
            ->where('phone_number', '=', $phone_number)
            ->where('phone_number_verified_at', '!=', null)
            ->firstOrFail();
    }

    function firstOrCreate(string $phone_number, array $attributes)
    {
        $user = $this->findOneBy([
            'phone_number' => $phone_number,
        ]);
        if (!$user) {
            $user = $this->create($attributes);
        }
        return $user;
    }
}
