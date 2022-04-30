<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerCollectionResource;
use App\Http\Resources\CustomerResource;
use App\Interfaces\CustomerInterface;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    protected CustomerInterface $customerRepository;

    public function __construct(CustomerInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return CustomerCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new CustomerCollectionResource($this->customerRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new CustomerCollectionResource($this->customerRepository->all('*', 'id', 'desc'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerCreateRequest $request
     * @return CustomerResource
     */
    public function store(CustomerCreateRequest $request)
    {
        $customer = $this->customerRepository->create($request->only([
            'name',
            'logo',
            'description',
        ]));
        return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return CustomerResource
     */
    public function show(int $id)
    {
        $customer = $this->customerRepository->findOneOrFail($id);
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerUpdateRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(CustomerUpdateRequest $request, int $id)
    {
        return $this->customerRepository->update($request->only([
            'name',
            'logo',
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
        return $this->customerRepository->delete($id);
    }
}
