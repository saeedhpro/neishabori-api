<?php


namespace App\Repositories;

use App\Interfaces\ContactInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ContactRepository
 *
 * @package \App\Repositories
 */
class ContactRepository extends BaseRepository implements ContactInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
