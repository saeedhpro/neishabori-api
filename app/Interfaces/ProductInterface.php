<?php


namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface BaseInterface
 * @package App\Interfaces
 */
interface ProductInterface extends BaseInterface
{

    public function findBySlug(string $slug);

    public function searchByPagination(int $sort, string $sortBy, string $q, int $isSpecial, string $category, string $attributes, $min_price, $max_price, $stock, string $brands, int $page = 1, int $limit = 10);

    public function search(int $sort, string $sortBy, string $q, int $isSpecial, string $category, string $attributes, $min_price, $max_price, $stock, string $brands);

    public function maxPrice();
    public function minPrice();

    public function whereIn(string $column, array $ids): Builder;
}
