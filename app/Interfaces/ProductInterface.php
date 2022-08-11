<?php


namespace App\Interfaces;

/**
 * Interface BaseInterface
 * @package App\Interfaces
 */
interface ProductInterface extends BaseInterface
{

    public function findBySlug(string $slug);
}
