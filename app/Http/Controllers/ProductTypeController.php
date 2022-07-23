<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductTypeCollectionResource;
use App\Interfaces\ProductTypeInterface;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductTypeController extends Controller
{
    protected ProductTypeInterface $productTypeRepository;

    public function __construct(ProductTypeInterface $productTypeRepository)
    {
        $this->productTypeRepository = $productTypeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ProductTypeCollectionResource
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ProductTypeCollectionResource($this->productTypeRepository->allByPagination('*', 'id', 'asc', $page, $limit));
        } else {
            return new ProductTypeCollectionResource($this->productTypeRepository->all('*', 'id', 'asc'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param ProductType $productType
     * @return Response
     */
    public function show(ProductType $productType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProductType $productType
     * @return Response
     */
    public function edit(ProductType $productType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ProductType $productType
     * @return Response
     */
    public function update(Request $request, ProductType $productType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductType $productType
     * @return Response
     */
    public function destroy(ProductType $productType)
    {
        //
    }
}
