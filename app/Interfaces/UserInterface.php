<?php


namespace App\Interfaces;

/**
 * Interface BaseInterface
 * @package App\Interfaces
 */
interface UserInterface extends BaseInterface
{
    function findOneByPhoneNumberOrFail(string $phone_number);
}
