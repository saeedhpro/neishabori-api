<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponCreateRequest;
use App\Http\Resources\CouponCollectionResource;
use App\Http\Resources\CouponResource;
use App\Interfaces\CouponInterface;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    protected CouponInterface $couponRepository;

    public function __construct(CouponInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return CouponCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            $expired = $this->getParam('expired');
            return new CouponCollectionResource($this->couponRepository->allByPagination('*', 'id', 'DESC', $page, $limit));
        } else {
            return new CouponCollectionResource($this->couponRepository->all());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CouponCreateRequest $request
     * @return CouponResource
     */
    public function store(CouponCreateRequest $request)
    {
        $code = $this->randomCode(8);
        $request['code'] = $code;
        $coupon = $this->couponRepository->create($request->only([
            'title',
            'code',
            'type',
            'status',
            'value',
            'description',
            'limit',
            'expired_at'
        ]));
        return new CouponResource($coupon);
    }

    /**
     * Display the specified resource.
     *
     * @param string $code
     * @return CouponResource
     */
    public function show(string $code)
    {
        return new CouponResource($this->couponRepository->findOneByOrFail([
            'code' => $code,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }
}
