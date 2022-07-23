<?php


namespace App\Repositories;

use App\Interfaces\BrandInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BrandRepository
 *
 * @package \App\Repositories
 */
class BrandRepository extends BaseRepository implements BrandInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
