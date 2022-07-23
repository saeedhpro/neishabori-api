<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductSizeCollectionResource;
use App\Interfaces\ProductSizeInterface;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductSizeController extends Controller
{
    protected ProductSizeInterface $productSizeRepository;

    public function __construct(ProductSizeInterface $productSizeRepository)
    {
        $this->productSizeRepository = $productSizeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ProductSizeCollectionResource
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ProductSizeCollectionResource($this->productSizeRepository->allByPagination('*', 'id', 'asc', $page, $limit));
        } else {
            return new ProductSizeCollectionResource($this->productSizeRepository->all('*', 'id', 'asc'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSize $productSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductSize $productSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductSize $productSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductSize  $productSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductSize $productSize)
    {
        //
    }
}
