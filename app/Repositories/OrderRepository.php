<?php


namespace App\Repositories;

use App\Interfaces\OrderInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderRepository
 *
 * @package \App\Repositories
 */
class OrderRepository extends BaseRepository implements OrderInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    private function getQuery(int $userID, string $type)
    {
        $query = $this->model
            ->where('user_id', '=', $userID);
        if ($type) {
            $query = $query->where('status', '=', $type);
        }
        return $query;
    }

    public function userOrderListByType(int $userID, string $type = 'created')
    {
        return $this->getQuery($userID, $type)->get();
    }

    public function userOrderList(int $userID)
    {
        return $this->getQuery($userID, '')->get();
    }
}
