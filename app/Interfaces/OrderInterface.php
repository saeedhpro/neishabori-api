<?php


namespace App\Interfaces;

/**
 * Interface OrderInterface
 * @package App\Interfaces
 */
interface OrderInterface extends BaseInterface
{
    /**
     * Return all model rows
     * @param int $userID
     * @param string $type
     * @return mixed
     */
    public function userOrderListByType(int $userID, string $type = 'created');

    /**
     * Return all model rows
     * @param int $userID
     * @return mixed
     */
    public function userOrderList(int $userID);
}
