<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryCollectionResource;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryInterface;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    protected CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $type = \request()->get('type');
        if(!$type) {
            return $this->createError('type', 'type not found', 422);
        }
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new CategoryCollectionResource($this->categoryRepository->allWithTypeByPagination('*', 'id', 'desc', $type, $page, $limit));
        } else {
            return new CategoryCollectionResource($this->categoryRepository->allWithType('*', 'id', 'desc', $type));
        }
    }

    public function all()
    {
        $type = \request()->get('type');
        if(!$type) {
            return $this->createError('type', 'type not found', 422);
        }
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new CategoryCollectionResource($this->categoryRepository->allTypeByPagination('*', 'id', 'desc', $type, $page, $limit));
        } else {
            return new CategoryCollectionResource($this->categoryRepository->allType('*', 'id', 'desc', $type));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryCreateRequest $request
     * @return CategoryResource
     */
    public function store(CategoryCreateRequest $request)
    {
        $category = $this->categoryRepository->create($request->only([
            'name',
            'thumbnail',
            'type',
            'parent_id',
        ]));
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CategoryResource
     */
    public function show(int $id)
    {
        return new CategoryResource($this->categoryRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CategoryUpdateRequest $request, int $id)
    {
        return $this->categoryRepository->update($request->only([
            'name',
            'thumbnail',
            'type',
            'parent_id',
        ]), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->categoryRepository->delete($id);
    }
}
