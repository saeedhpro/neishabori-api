<?php

namespace App\Http\Controllers;

use App\Constants\Constants;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function createError(string $name, string $error, int $status): JsonResponse
    {
        return response()->json(['errors' => [ $name => [$error]]], $status);
    }

    protected function createCustomResponse($content = null, int $status = 200): JsonResponse
    {
        return response()->json($content, $status);
    }

    protected function accessDeniedError(): JsonResponse
    {
        return $this->createError('access', Constants::ACCESS_ERROR, 403);
    }

    /**
     * @return bool
     */
    public function hasPage(): bool
    {
        return request()->has('page');
    }

    /**
     * @return int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPage(): int
    {
        return request()->has('page') ? request()->get('page') : 1;
    }

    /**
     * @return int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getLimit(): int
    {
        return request()->has('limit') ? request()->get('limit') : 10;
    }
}
