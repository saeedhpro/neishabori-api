<?php


namespace App\Repositories;


use App\Interfaces\CustomerInterface;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomerRepository extends BaseRepository implements CustomerInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
