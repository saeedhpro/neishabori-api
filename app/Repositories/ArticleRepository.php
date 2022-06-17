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

    public function searchByPaginate($sortBy = 'id', $orderBy = 'desc', $q = null, $categoryId = null, $page = 1, $limit = 10)
    {
        return  $this->getQuery($sortBy, $orderBy, $q, $categoryId)->paginate($limit);
    }

    public function search($sortBy = 'id', $orderBy = 'desc', $q = null, $categoryId = null)
    {
        return  $this->getQuery($sortBy, $orderBy, $q, $categoryId)->get();
    }

    private function getQuery($sortBy = 'id', $orderBy = 'desc', $q = null, $categoryId = null) : Builder
    {
        $query = $this->model->orderBy($orderBy, $sortBy);
        $query = $query->when($q, function ($query) use ($q) {
            $query->where('title', 'like', "%$q%")
                ->orWhere('body', 'like', "%$q%");
        });
        $query = $query->when($categoryId, function ($query) use ($categoryId) {
            $query->where('category_id', '=', $categoryId);
        });
        return $query;
    }

    public function findBySlug(string $slug)
    {
        return $this->findOneByOrFail([
            'slug' => $slug
        ]);
    }
}
