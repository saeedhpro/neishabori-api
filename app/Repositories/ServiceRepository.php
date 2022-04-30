<?php


namespace App\Repositories;


use App\Interfaces\ServiceInterface;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServiceRepository extends BaseRepository implements ServiceInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
