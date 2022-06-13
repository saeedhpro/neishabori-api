<?php

namespace App\Http\Controllers;

use App\Http\Resources\SkillCollectionResource;
use App\Http\Resources\SkillResource;
use App\Interfaces\SkillInterface;
use App\Models\Skill;
use Illuminate\Http\Request;

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
            return new SkillCollectionResource($this->skillRepository->allByPagination('*', 'id', 'asc', $page, $limit));
        } else {
            return new SkillCollectionResource($this->skillRepository->all('*', 'id', 'asc'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
