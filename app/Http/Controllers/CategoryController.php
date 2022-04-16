<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollectionResource;
use App\Interfaces\CategoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;

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
            return new CategoryCollectionResource($this->categoryRepository->allWithTypeByPagination('*', 'id', 'DESC', $type, $page, $limit));
        } else {
            return new CategoryCollectionResource($this->categoryRepository->allWithType($type));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
