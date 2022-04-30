<?php


namespace App\Repositories;


use App\Interfaces\ServiceRequestInterface;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestRepository extends BaseRepository implements ServiceRequestInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
