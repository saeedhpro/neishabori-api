<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandCollectionResource;
use App\Interfaces\BrandInterface;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class BrandController extends Controller
{
    protected BrandInterface $brandRepository;

    public function __construct(BrandInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return BrandCollectionResource
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new BrandCollectionResource($this->brandRepository->allByPagination('*', 'id', 'asc', $page, $limit));
        } else {
            return new BrandCollectionResource($this->brandRepository->all('*', 'id', 'asc'));
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
     * @param Brand $brand
     * @return Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Brand $brand
     * @return Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Brand $brand
     * @return Response
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return Response
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
