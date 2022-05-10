<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressCreateRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Resources\AddressCollectionResource;
use App\Http\Resources\AddressResource;
use App\Interfaces\AddressInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class AddressController extends Controller
{

    protected AddressInterface $addressRepository;

    public function __construct(AddressInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function ownAddresses(): AddressCollectionResource
    {
        $own = $this->getAuth();
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new AddressCollectionResource($this->addressRepository->searchByPaginate($own->id, 'id', 'desc', $page, $limit));
        } else {
            return new AddressCollectionResource($this->addressRepository->search($own->id));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressCreateRequest $request
     * @return AddressResource
     */
    public function store(AddressCreateRequest $request)
    {
        $own = $this->getAuth();
        $request['user_id'] = $own->id;
        $address = $this->addressRepository->create($request->only([
            'address',
            'plate',
            'uint',
            'postal_code',
            'recipient_first_name',
            'recipient_last_name',
            'recipient_phone_number',
            'user_id',
            'city_id',
        ]));
        return new AddressResource($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddressUpdateRequest $request
     * @param int $id
     * @return bool
     */
    public function update(AddressUpdateRequest $request, int $id)
    {
        return $this->addressRepository->update($request->only([
            'address',
            'plate',
            'uint',
            'postal_code',
            'recipient_first_name',
            'recipient_last_name',
            'recipient_phone_number',
            'city_id',
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
        return $this->addressRepository->delete($id);
    }
}
