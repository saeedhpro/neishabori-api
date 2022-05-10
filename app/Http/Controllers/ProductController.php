<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\ProductCollectionResource;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductController extends Controller
{

    protected ProductInterface $productRepository;

    /**
     * Display a listing of the resource.
     *
     * @return ProductCollectionResource
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ProductCollectionResource($this->productRepository->allByPagination('*', 'id', 'DESC', $page, $limit));
        } else {
            return new ProductCollectionResource($this->productRepository->all());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCreateRequest $request
     * @return ProductResource
     */
    public function store(ProductCreateRequest $request)
    {
        $product = $this->productRepository->create($request->only([

        ]));
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ProductResource
     */
    public function show(int $id)
    {
        return new ProductResource($this->productRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductCreateRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(ProductCreateRequest $request, int $id)
    {
        return $this->productRepository->update($request->only([

        ]), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->productRepository->delete($id);
    }

    public function toggleFavourite(int $id): bool
    {
        /** @var Product $product */
        $product = $this->productRepository->findOneOrFail($id);
        $own = $this->getAuth();
        $own->toggleFavorite($product);
        return true;
    }
}
