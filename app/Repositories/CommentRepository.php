<?php


namespace App\Repositories;


use App\Interfaces\CommentInterface;
use Illuminate\Database\Eloquent\Model;

class CommentRepository extends BaseRepository implements CommentInterface
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
