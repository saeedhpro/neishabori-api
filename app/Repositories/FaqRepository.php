<?php


namespace App\Repositories;

use App\Interfaces\FaqInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FaqRepository
 *
 * @package \App\Repositories
 */
class FaqRepository extends BaseRepository implements FaqInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
