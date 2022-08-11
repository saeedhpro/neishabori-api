<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Http\Resources\ArticleCollectionResource;
use App\Http\Resources\ArticleResource;
use App\Interfaces\ArticleInterface;
use App\Models\Article;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use function request;

class ArticleController extends Controller
{
    protected ArticleInterface $articleRepository;

    public function __construct(ArticleInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ArticleCollectionResource
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): ArticleCollectionResource
    {
        $q = request()->get('q');
        $categoryId = request()->get('category_id');
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ArticleCollectionResource($this->articleRepository->searchByPaginate('desc', 'id', $q, $categoryId, $page, $limit));
        } else {
            return new ArticleCollectionResource($this->articleRepository->search('desc', 'id', $q, $categoryId));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleCreateRequest $request
     * @return ArticleResource
     */
    public function store(ArticleCreateRequest $request): ArticleResource
    {
        $user = $this->getAuth();
        $request['user_id'] = $user->id;
        /** @var Article $article */
        $article = $this->articleRepository->create($request->only([
            'title',
            'body',
            'thumbnail',
            'summary',
            'user_id',
            'category_id',
        ]));
        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return ArticleResource
     */
    public function show(string $slug): ArticleResource
    {
        return new ArticleResource($this->articleRepository->findBySlug($slug));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleUpdateRequest $request
     * @param int $id
     * @return ArticleResource
     */
    public function update(ArticleUpdateRequest $request, int $id): ArticleResource
    {
        /** @var Article $article */
        $this->articleRepository->update($request->only([
            'title',
            'body',
            'summary',
            'thumbnail',
            'category_id',
        ]), $id);
        $article = $this->articleRepository->findOneOrFail($id);
        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->articleRepository->delete($id);
    }
}
