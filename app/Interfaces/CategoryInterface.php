<?php


namespace App\Interfaces;

/**
 * Interface BaseInterface
 * @package App\Interfaces
 */
interface CategoryInterface extends BaseInterface
{
    /**
     * Return all model rows by paginate
     * @param string[] $columns
     * @param string $orderBy
     * @param string $sortBy
     * @param int $page
     * @param int $limit
     * @return mixed
     */
    public function allWithTypeByPagination($columns = array('*') ,$orderBy = 'id', $sortBy = 'desc', $type = null, $page = 1, $limit = 10);
    /**
     * Return all model rows by paginate
     * @param string[] $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function allWithType($columns = array('*') ,$orderBy = 'id', $sortBy = 'desc', $type = null);

    /**
     * @param int $parentID
     * @return mixed
     */
    public function children(int $parentID);
}
