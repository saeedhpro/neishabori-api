<?php


namespace App\Interfaces;

/**
 * Interface BaseInterface
 * @package App\Interfaces
 */
interface OtpInterface extends BaseInterface
{
    public function generate(string $phone_number, int $length = 4);
    public function findByPhoneNumberOrFail(string $phone_number);
}
