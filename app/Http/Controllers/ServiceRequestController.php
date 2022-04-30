<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequestCreateRequest;
use App\Http\Requests\ServiceRequestUpdateRequest;
use App\Http\Resources\ServiceRequestCollectionResource;
use App\Http\Resources\ServiceRequestResource;
use App\Interfaces\ServiceRequestInterface;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceRequestController extends Controller
{

    protected ServiceRequestInterface $serviceRequestRepository;

    public function __construct(ServiceRequestInterface $serviceRequestRepository)
    {
        $this->serviceRequestRepository = $serviceRequestRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ServiceRequestCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ServiceRequestCollectionResource($this->serviceRequestRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new ServiceRequestCollectionResource($this->serviceRequestRepository->all());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequestCreateRequest $request
     * @return ServiceRequestResource
     */
    public function store(ServiceRequestCreateRequest $request)
    {
        $serviceRequest = $this->serviceRequestRepository->create($request->only([
            'full_name',
            'service_id',
            'time',
            'city_id',
            'address',
            'plate',
            'phone_number',
        ]));
        return new ServiceRequestResource($serviceRequest);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ServiceRequestResource
     */
    public function show(int $id)
    {
        return new ServiceRequestResource($this->serviceRequestRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceRequestUpdateRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(ServiceRequestUpdateRequest $request, int $id)
    {
        return $this->serviceRequestRepository->update($request->only([
            'full_name',
            'service_id',
            'time',
            'city_id',
            'address',
            'plate',
            'phone_number',
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
        return $this->serviceRequestRepository->delete($id);
    }
}
