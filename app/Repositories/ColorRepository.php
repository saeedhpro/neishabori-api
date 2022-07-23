<?php


namespace App\Repositories;

use App\Interfaces\ColorInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ColorRepository
 *
 * @package \App\Repositories
 */
class ColorRepository extends BaseRepository implements ColorInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
