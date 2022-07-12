<?php


namespace App\Interfaces;

/**
 * Interface CommentInterface
 * @package App\Interfaces
 */
interface CommentInterface extends BaseInterface
{
    public function children(int $id, int $limit);
}
