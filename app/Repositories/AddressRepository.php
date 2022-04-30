<?php


namespace App\Repositories;

use App\Interfaces\AddressInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AddressRepository
 *
 * @package \App\Repositories
 */
class AddressRepository extends BaseRepository implements AddressInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function searchByPaginate(int $userID, $sortBy = 'id', $orderBy = 'desc', $page = 1, $limit = 10)
    {
        return $this->getQuery($userID, $sortBy, $orderBy)->paginate($limit);
    }

    public function search(int $userID, $sortBy = 'id', $orderBy = 'desc')
    {
        return $this->getQuery($userID, $sortBy, $orderBy)->get();
    }

    private function getQuery(int $userID, $sortBy = 'id', $orderBy = 'desc'): Builder
    {
        return $this->model->where('user_id', '=', $userID)
            ->orderBy($orderBy, $sortBy);
    }
}
