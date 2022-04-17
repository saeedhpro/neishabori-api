<?php


namespace App\Repositories;


use App\Interfaces\OtpInterface;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OtpRepository extends BaseRepository implements OtpInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function generate(string $phone_number, int $length = 4)
    {
        $code = $this->generateRandomString($length);
        $otp = $this->findOneBy([
            'phone_number' => $phone_number,
        ]);
        if ($otp) {
            $this->delete($otp->id);
        }
        $otp = $this->create([
            'phone_number' => $phone_number,
            'code' => $code,
        ]);
        return $otp->code;
    }

    private function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function findByPhoneNumberOrFail(string $phone_number)
    {
        return $this->model
            ->where('phone_number', '=', $phone_number)
            ->where('created_at', '>=', Carbon::now()->subMinute())
            ->first();
    }
}
