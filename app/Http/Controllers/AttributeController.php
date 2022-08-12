<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeCreateRequest;
use App\Http\Requests\AttributeUpdateRequest;
use App\Http\Resources\AttributeCollectionResource;
use App\Http\Resources\AttributeResource;
use App\Interfaces\AttributeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttributeController extends Controller
{
    protected AttributeInterface $attributeRepository;

    public function __construct(AttributeInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AttributeCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new AttributeCollectionResource($this->attributeRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new AttributeCollectionResource($this->attributeRepository->all());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeCreateRequest $request
     * @return AttributeResource
     */
    public function store(AttributeCreateRequest $request)
    {
        $attribute = $this->attributeRepository->create($request->only([
            'name',
            'type',
            'category_id',
        ]));
        return new AttributeResource($attribute);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return AttributeResource
     */
    public function show(int $id)
    {
        return new AttributeResource($this->attributeRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(AttributeUpdateRequest $request, int $id)
    {
        return $this->attributeRepository->update($request->only([
            'name',
            'type',
            'category_id',
        ]), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(int $id)
    {
        return $this->attributeRepository->delete($id);
    }
}
