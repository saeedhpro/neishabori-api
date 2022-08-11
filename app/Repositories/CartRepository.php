<?php


namespace App\Repositories;

use App\Interfaces\CartInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CartRepository
 *
 * @package \App\Repositories
 */
class CartRepository extends BaseRepository implements CartInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function userCart(int $userID)
    {
        return $this->getQuery($userID)->first();
    }

    private function getQuery(int $userID)
    {
        return $this->model->where('user_id', '=', $userID);
    }
}
