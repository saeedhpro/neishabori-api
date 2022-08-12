<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandCreateRequest;
use App\Http\Requests\BrandUpdateRequest;
use App\Http\Resources\BrandCollectionResource;
use App\Http\Resources\BrandResource;
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
     * Store a newly created resource in storage.
     *
     * @param BrandCreateRequest $request
     * @return BrandResource
     */
    public function store(BrandCreateRequest $request)
    {
        $brand = $this->brandRepository->create($request->only([
            'name',
            'image',
        ]));
        return new BrandResource($brand);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return BrandResource
     */
    public function show(int $id)
    {
        return new BrandResource($this->brandRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(BrandUpdateRequest $request, int $id)
    {
        return $this->brandRepository->update($request->only([
            'name',
            'image',
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
        return $this->brandRepository->delete($id);
    }
}
