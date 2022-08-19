<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionCreateRequest;
use App\Http\Requests\QuestionUpdateRequest;
use App\Http\Resources\QuestionCollectionResource;
use App\Http\Resources\QuestionResource;
use App\Interfaces\QuestionInterface;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends Controller
{

    protected QuestionInterface $questionRepository;

    public function __construct(QuestionInterface $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return QuestionCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new QuestionCollectionResource($this->questionRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new QuestionCollectionResource($this->questionRepository->all());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return QuestionCollectionResource
     */
    public function questions(int $id)
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new QuestionCollectionResource($this->questionRepository->findByPaginate([
                'product_id' => $id,
                'parent_id' => null,
            ], $page, $limit));
        } else {
            return new QuestionCollectionResource($this->questionRepository->findBy([
                'product_id' => $id,
                'parent_id' => null,
            ]));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return QuestionCollectionResource
     */
    public function children(int $id)
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new QuestionCollectionResource($this->questionRepository->findByPaginate([
                'parent_id' => $id,
            ], $page, $limit));
        } else {
            return new QuestionCollectionResource($this->questionRepository->findBy([
                'parent_id' => $id,
            ]));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionCreateRequest $request
     * @return QuestionResource
     */
    public function store(QuestionCreateRequest $request)
    {
        $question = $this->questionRepository->create($request->only([
            'accept',
            'question',
            'user_id',
            'parent_id',
        ]));
        return new QuestionResource($question);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return QuestionResource
     */
    public function show(int $id)
    {
        return new QuestionResource($this->questionRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(QuestionUpdateRequest $request, int $id)
    {
        return $this->questionRepository->update($request->only([
            'accept',
            'question',
            'parent_id',
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
        return $this->questionRepository->delete($id);
    }
}
