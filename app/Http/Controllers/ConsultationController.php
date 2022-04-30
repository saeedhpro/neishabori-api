<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultationCreateRequest;
use App\Http\Requests\ConsultationUpdateRequest;
use App\Http\Resources\ConsultationCollectionResource;
use App\Http\Resources\ConsultationResource;
use App\Interfaces\ConsultationInterface;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ConsultationController extends Controller
{
    protected ConsultationInterface $consultationRepository;

    public function __construct(ConsultationInterface $consultationRepository)
    {
        $this->consultationRepository = $consultationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ConsultationCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ConsultationCollectionResource($this->consultationRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new ConsultationCollectionResource($this->consultationRepository->all('*', 'id', 'desc'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsultationCreateRequest $request
     * @return ConsultationResource
     */
    public function store(ConsultationCreateRequest $request)
    {
        $consultation = $this->consultationRepository->create($request->only([
            'full_name',
            'phone_number',
            'tel',
            'description',
        ]));
        return new ConsultationResource($consultation);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ConsultationResource
     */
    public function show(int $id)
    {
        $consultation = $this->consultationRepository->findOneOrFail($id);
        return new ConsultationResource($consultation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConsultationUpdateRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(ConsultationUpdateRequest $request, int $id): Response
    {
        return $this->consultationRepository->update($request->only([
            'full_name',
            'phone_number',
            'tel',
            'description',
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
        return $this->consultationRepository->delete($id);
    }
}
