<?php


namespace App\Repositories;

use App\Interfaces\CouponInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CouponRepository
 *
 * @package \App\Repositories
 */
class CouponRepository extends BaseRepository implements CouponInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
