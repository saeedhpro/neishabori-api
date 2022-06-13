<?php


namespace App\Repositories;


use App\Interfaces\CooperationRequestInterface;
use Illuminate\Database\Eloquent\Model;

class CooperationRequestRepository extends BaseRepository implements CooperationRequestInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
