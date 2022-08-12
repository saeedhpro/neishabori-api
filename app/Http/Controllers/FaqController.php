<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqCreateRequest;
use App\Http\Requests\FaqUpdateRequest;
use App\Http\Resources\FaqCollectionResource;
use App\Http\Resources\FaqResource;
use App\Interfaces\FaqInterface;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FaqController extends Controller
{

    protected FaqInterface $faqRepository;

    public function __construct(FaqInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return FaqCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new FaqCollectionResource($this->faqRepository->allByPagination('*', 'created_at', 'desc', $page, $limit));
        } else {
            return new FaqCollectionResource($this->faqRepository->all());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FaqCreateRequest $request
     * @return FaqResource
     */
    public function store(FaqCreateRequest $request)
    {
        $faq = $this->faqRepository->create($request->only([
            'category_id',
            'question',
            'answer',
        ]));
        return new FaqResource($faq);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return FaqResource
     */
    public function show(int $id)
    {
        return new FaqResource($this->faqRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FaqUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(FaqUpdateRequest $request, int $id)
    {
        return $this->faqRepository->update($request->only([
            'category_id',
            'question',
            'answer',
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
        return $this->faqRepository->delete($id);
    }
}
