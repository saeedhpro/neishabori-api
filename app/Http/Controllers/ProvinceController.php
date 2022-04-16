<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProvinceCollectionResource;
use App\Interfaces\ProvinceInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProvinceController extends Controller
{

    protected ProvinceInterface $provinceRepository;

    public function __construct(ProvinceInterface $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ProvinceCollectionResource
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): ProvinceCollectionResource
    {
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ProvinceCollectionResource($this->provinceRepository->allByPagination('*', 'id', 'desc', $page, $limit));
        } else {
            return new ProvinceCollectionResource($this->provinceRepository->all('*', 'id', 'desc'));
        }
    }
}
