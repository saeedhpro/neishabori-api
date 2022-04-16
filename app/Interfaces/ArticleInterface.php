<?php


namespace App\Interfaces;

/**
 * Interface ArticleInterface
 * @package App\Interfaces
 */
interface ArticleInterface extends BaseInterface
{
    /**
     * Return all model rows
     * @param string $orderBy
     * @param string $sortBy
     * @param null $q
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function searchByPaginate($sortBy = 'id', $orderBy = 'desc', $q = null, $page = 1, $limit = 10);

    /**
     * Return all model rows
     * @param string $orderBy
     * @param string $sortBy
     * @param null $q
     * @return mixed
     */
    public function search($sortBy = 'id', $orderBy = 'desc', $q = null);

    /**
     * Return all model rows
     * @param string $slug
     * @return mixed
     */
    public function findBySlug(string $slug);
}
