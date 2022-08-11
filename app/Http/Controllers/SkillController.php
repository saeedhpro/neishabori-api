<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillCreateRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Http\Resources\SkillCollectionResource;
use App\Http\Resources\SkillResource;
use App\Interfaces\SkillInterface;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SkillController extends Controller
{
    protected SkillInterface $skillRepository;

    public function __construct(SkillInterface $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return SkillCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new SkillCollectionResource($this->skillRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new SkillCollectionResource($this->skillRepository->all('*', 'id', 'desc'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SkillCreateRequest $request
     * @return SkillResource
     */
    public function store(SkillCreateRequest $request)
    {
        $skill = $this->skillRepository->create($request->only([
            'name',
        ]));
        return new SkillResource($skill);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return SkillResource
     */
    public function show(int $id)
    {
        return new SkillResource($this->skillRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SkillUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(SkillUpdateRequest $request, int $id)
    {
        return $this->skillRepository->update($request->only([
            'name',
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
        return $this->skillRepository->delete($id);
    }
}
