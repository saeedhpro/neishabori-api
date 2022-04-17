<?php


namespace App\Repositories;


use App\Interfaces\OrganizationInterface;
use Illuminate\Database\Eloquent\Model;

class OrganizationRepository extends BaseRepository implements OrganizationInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
