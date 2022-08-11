<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentCollectionResource;
use App\Http\Resources\CommentResource;
use App\Interfaces\CommentInterface;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CommentController extends Controller
{
    protected CommentInterface $commentRepository;

    public function __construct(CommentInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentCreateRequest $request
     * @return CommentResource
     */
    public function store(CommentCreateRequest $request)
    {
        $comment = $this->commentRepository->create($request->only([
            'type',
            'body',
            'user_id',
            'commentable_id',
        ]));
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CommentResource
     */
    public function show(int $id)
    {
        return new CommentResource($this->commentRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommentUpdateRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(CommentUpdateRequest $request, int $id)
    {
        return $this->commentRepository->update($request->only([
            'body',
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
        return $this->commentRepository->delete($id);
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function ownComments()
    {
        $type = request()->get('type');
        $own = $this->getAuth();
        if (!$type || ($type != Comment::TYPE_ARTICLE || $type != Comment::TYPE_PRODUCT)) {
            return $this->createError('type', 'نوع نظر الزامی است', 500);
        }
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new CommentCollectionResource($this->commentRepository->findByPaginate([
                'user_id' => $own->id,
                'type' => $type,
            ], $page, $limit));
        } else {
            return new CommentCollectionResource($this->commentRepository->findBy([
                'user_id' => $own->id,
                'type' => $type,
            ]));
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function children(int $id)
    {
        if ($this->hasLimit()) {
            $limit = $this->getLimit();
            return new CommentCollectionResource($this->commentRepository->children($id, $limit));
        }
        return new CommentCollectionResource($this->commentRepository->children($id));
    }
}
