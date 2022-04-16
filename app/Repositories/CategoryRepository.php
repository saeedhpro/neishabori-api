<?php


namespace App\Repositories;


use App\Interfaces\CategoryInterface;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository extends BaseRepository implements CategoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function children(int $parentID)
    {
        return $this->findBy([
            'parent_id' => $parentID,
        ]);
    }

    public function allWithTypeByPagination($columns = array('*') ,$orderBy = 'id', $sortBy = 'desc', $type = null, $page = 1, $limit = 10)
    {
        $query = $this->getQuery($orderBy, $sortBy, $type);
        return $query->paginate($limit);
    }

    public function allWithType($columns = array('*') ,$orderBy = 'id', $sortBy = 'desc', $type = null)
    {
        return $this->getQuery($orderBy, $sortBy, $type)->get();
    }

    private function getQuery($orderBy, $sortBy, $type)
    {
        $query = $this->model->orderBy($orderBy, $sortBy);
        return $query->when($type, function ($q) use ($type) {
            $q->where('type', '=', $this);
        });
    }
}
