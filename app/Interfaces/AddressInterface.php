<?php


namespace App\Interfaces;

/**
 * Interface AddressInterface
 * @package App\Interfaces
 */
interface AddressInterface extends BaseInterface
{
    /**
     * Return all model rows
     * @param int $userID
     * @param string $orderBy
     * @param string $sortBy
     * @param null $q
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function searchByPaginate(int $userID, $sortBy = 'id', $orderBy = 'desc', $page = 1, $limit = 10);

    /**
     * Return all model rows
     * @param int $userID
     * @param string $orderBy
     * @param string $sortBy
     * @param null $q
     * @return mixed
     */
    public function search(int $userID, $sortBy = 'id', $orderBy = 'desc');
}
