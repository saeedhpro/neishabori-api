<?php


namespace App\Repositories;


use App\Interfaces\ProductInterface;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ProductRepository extends BaseRepository implements ProductInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
