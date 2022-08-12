<?php

namespace App\Http\Controllers;

use App\Http\Requests\CooperationRequestCreateRequest;
use App\Http\Requests\CooperationRequestUpdateRequest;
use App\Http\Resources\CooperationRequestCollectionResource;
use App\Http\Resources\CooperationRequestResource;
use App\Interfaces\CooperationRequestInterface;
use App\Models\CooperationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CooperationRequestController extends Controller
{
    protected CooperationRequestInterface $cooperationRequestRepository;

    public function __construct(CooperationRequestInterface $cooperationRequestRepository)
    {
        $this->cooperationRequestRepository = $cooperationRequestRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return CooperationRequestCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new CooperationRequestCollectionResource($this->cooperationRequestRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new CooperationRequestCollectionResource($this->cooperationRequestRepository->all('*', 'id', 'desc'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CooperationRequestCreateRequest $request)
    {
        return $this->cooperationRequestRepository->create($request->only([
            'full_name',
            'phone_number',
            'skill_id',
            'city_id',
            'address',
            'description',
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CooperationRequestResource
     */
    public function show(int $id)
    {
        return new CooperationRequestResource($this->cooperationRequestRepository->findOneOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->cooperationRequestRepository->delete($id);
    }
}
