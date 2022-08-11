<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceCreateRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Http\Resources\ServiceCollectionResource;
use App\Http\Resources\ServiceResource;
use App\Interfaces\ServiceInterface;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceController extends Controller
{

    protected ServiceInterface $serviceRepository;

    public function __construct(ServiceInterface $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ServiceCollectionResource
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ServiceCollectionResource($this->serviceRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new ServiceCollectionResource($this->serviceRepository->all('*', 'id', 'desc'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceCreateRequest $request
     * @return ServiceResource
     */
    public function store(ServiceCreateRequest $request)
    {
        $service = $this->serviceRepository->create($request->only([
            'title',
            'thumbnail',
        ]));
        return new ServiceResource($service);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ServiceResource
     */
    public function show(int $id)
    {
        $service = $this->serviceRepository->findOneOrFail($id);
        return new ServiceResource($service);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceUpdateRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(ServiceUpdateRequest $request, int $id)
    {
        return $this->serviceRepository->update($request->only([
            'title',
            'thumbnail',
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
        return $this->serviceRepository->delete($id);
    }
}
