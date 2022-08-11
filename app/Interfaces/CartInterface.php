<?php


namespace App\Interfaces;

/**
 * Interface CartInterface
 * @package App\Interfaces
 */
interface CartInterface extends BaseInterface
{
    public function userCart(int $userID);
}
