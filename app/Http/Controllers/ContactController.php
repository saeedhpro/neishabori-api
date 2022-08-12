<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactCreateRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactCollectionResource;
use App\Http\Resources\ContactResource;
use App\Interfaces\ContactInterface;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    protected ContactInterface $contactRepository;

    public function __construct(ContactInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ContactCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ContactCollectionResource($this->contactRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new ContactCollectionResource($this->contactRepository->all());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactCreateRequest $request
     * @return ContactResource
     */
    public function store(ContactCreateRequest $request)
    {
        $contact = $this->contactRepository->create($request->only([
            'full_name',
            'phone_number',
            'body',
        ]));
        return new ContactResource($contact);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ContactResource
     */
    public function show(int $id)
    {
        return new ContactResource($this->contactRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactUpdateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ContactUpdateRequest $request, int $id)
    {
        return $this->contactRepository->update($request->only([
            'full_name',
            'phone_number',
            'body',
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
        return $this->contactRepository->delete($id);
    }
}
