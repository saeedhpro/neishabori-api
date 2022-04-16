<?php


namespace App\Repositories;

use App\Interfaces\ArticleInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleRepository
 *
 * @package \App\Repositories
 */
class ArticleRepository extends BaseRepository implements ArticleInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function searchByPaginate($sortBy = 'id', $orderBy = 'desc', $q = null, $page = 1, $limit = 10)
    {
        return  $this->getQuery($sortBy, $orderBy, $q)->paginate($limit);
    }

    public function search($sortBy = 'id', $orderBy = 'desc', $q = null)
    {
        return  $this->getQuery($sortBy, $orderBy, $q)->get();
    }

    private function getQuery($sortBy = 'id', $orderBy = 'desc', $q = null) : Builder
    {
        $query = $this->model->orderBy($orderBy, $sortBy);
        return $query->when($q, function ($query) use ($q) {
            $query->where('title', 'like', "%$q%")
                ->orWhere('body', 'like', "%$q%");
        });
    }

    public function findBySlug(string $slug)
    {
        return $this->findOneByOrFail([
            'slug' => $slug
        ]);
    }
}
