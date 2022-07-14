<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollectionResource;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    protected OrderInterface $orderRepository;

    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function ownOrders()
    {
        $own = $this->getAuth();
        $type = \request()->get('type');
        if ($type) {
            return new OrderCollectionResource($this->orderRepository->userOrderListByType($own->id, $type));
        } else {
            return new OrderCollectionResource($this->orderRepository->userOrderList($own->id));
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
