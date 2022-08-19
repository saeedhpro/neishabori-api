<?php


namespace App\Repositories;

use App\Interfaces\QuestionInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionRepository
 *
 * @package \App\Repositories
 */
class QuestionRepository extends BaseRepository implements QuestionInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function children(int $id, int $limit = 3)
    {
        return $this->findBy([
            'parent_id' => $id,
        ])->take($limit);
    }
}
