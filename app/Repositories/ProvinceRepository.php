<?php


namespace App\Repositories;


use App\Interfaces\ProvinceInterface;
use Illuminate\Database\Eloquent\Model;

class ProvinceRepository extends BaseRepository implements ProvinceInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
