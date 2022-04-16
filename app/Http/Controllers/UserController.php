<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserCollectionResource;
use App\Http\Resources\UserLoginResource;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected UserInterface $userRepository;

    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(UserLoginRequest $request)
    {
        /** @var User $user */
        $user = $this->userRepository->findOneByPhoneNumberOrFail($request->get('phone_number'));
        if (Hash::check($request->password, $user->password)) {
            if ($user->is_admin) {
                $token = $user->createToken('achilan')->accessToken;
                return new UserLoginResource($user, $token);
            } else {
                return $this->accessDeniedError();
            }
        } else {
            return $this->createError('password', Constants::INVALID_PASSWORD_ERROR, 422);
        }
    }

    public function register(UserRegisterRequest $request)
    {
        $request['password'] = bcrypt($request->get('password'));
        /** @var User $user */
        $user = $this->userRepository->create($request->only([
            'phone_number',
            'full_name',
            'password',
        ]));
        return $this->createCustomResponse($user);
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
     * @param  int  $id
     * @return UserResource
     */
    public function show(int $id)
    {
        return new UserResource($this->userRepository->findOneOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
