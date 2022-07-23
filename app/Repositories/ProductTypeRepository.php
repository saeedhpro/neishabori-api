<?php


namespace App\Repositories;

use App\Interfaces\ProductTypeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductTypeRepository
 *
 * @package \App\Repositories
 */
class ProductTypeRepository extends BaseRepository implements ProductTypeInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
