<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\VerifyRegisterRequest;
use App\Http\Resources\UserCollectionResource;
use App\Http\Resources\UserLoginResource;
use App\Http\Resources\UserResource;
use App\Interfaces\OrganizationInterface;
use App\Interfaces\OtpInterface;
use App\Interfaces\UserInterface;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected UserInterface $userRepository;
    protected OrganizationInterface $organizationRepository;
    protected OtpInterface $otpRepository;

    public function __construct(
        UserInterface $userRepository,
        OrganizationInterface $organizationRepository,
        OtpInterface $otpRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->organizationRepository = $organizationRepository;
        $this->otpRepository = $otpRepository;
    }

    public function login(UserLoginRequest $request)
    {
        /** @var User $user */
        $user = $this->userRepository->findOneByPhoneNumberOrFail($request->get('phone_number'));
        if (Hash::check($request->password, $user->password)) {
            $token = $user->createToken('shop')->accessToken;
            return new UserLoginResource($user, $token);
        } else {
            return $this->createError('password', Constants::INVALID_PASSWORD_ERROR, 422);
        }
    }

    public function register(UserRegisterRequest $request)
    {
        $request['password'] = bcrypt($request->get('password'));
        $this->userRepository->firstOrCreate($request->get('phone_number'), $request->only([
            'phone_number',
            'full_name',
            'password',
        ]));
        $code = $this->otpRepository->generate($request->get('phone_number'));
        return $this->createCustomResponse($code);
    }

    public function verifyRegister(VerifyRegisterRequest $request)
    {
        /** @var User $user */
        $user = $this->userRepository->findOneByPhoneNumberOrFail($request->get('phone_number'));
        /** @var Otp $otp */
        $otp = $this->otpRepository->findByPhoneNumberOrFail($request->get('phone_number'));
        if ($otp->code == $request->get('code')) {
            $user->update([
                'phone_number_verified_at' => Carbon::now(),
            ]);
            return $this->createCustomResponse($user);
        } else {
            return $this->createError('code', Constants::INVALID_OTP_CODE_ERROR, 422);
        }
    }

    public function me()
    {
        return new UserResource($this->getAuth());
    }

    /**
     * Display a listing of the resource.
     *
     * @return UserCollectionResource
     */
    public function index()
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new UserCollectionResource($this->userRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new UserCollectionResource($this->userRepository->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return UserResource
     */
    public function show(int $id)
    {
        return new UserResource($this->userRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
