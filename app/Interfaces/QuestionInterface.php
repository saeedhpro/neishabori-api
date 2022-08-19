<?php


namespace App\Interfaces;

/**
 * Interface QuestionInterface
 * @package App\Interfaces
 */
interface QuestionInterface extends BaseInterface
{
    public function children(int $id, int $limit);
}
