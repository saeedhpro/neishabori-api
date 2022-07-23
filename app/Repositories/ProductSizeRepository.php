<?php


namespace App\Repositories;

use App\Interfaces\ProductSizeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductSizeRepository
 *
 * @package \App\Repositories
 */
class ProductSizeRepository extends BaseRepository implements ProductSizeInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
