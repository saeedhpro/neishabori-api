<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Interfaces\CartInterface;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartInterface $cartRepository;

    public function __construct(CartInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function addCartItem(AddToCartRequest $request)
    {

    }
}
