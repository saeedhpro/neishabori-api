<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductCollectionResource;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductInterface;
use App\Models\Attribute;
use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ProductController extends Controller
{

    protected ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ProductCollectionResource
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index()
    {
        $sort = \request()->has('sort') ? \request()->get('sort') : 1;
        $q = \request()->has('q') ? \request()->get('q') : '';
        $special = \request()->has('special') ? \request()->get('special') : 2;
        $category = \request()->has('category') ? \request()->get('category') : '';
        $brands = \request()->has('brands') ? \request()->get('brands') : '';
        $attributes = \request()->has('attributes') ? \request()->get('attributes') : '';
        $minPrice = \request()->has('min_price') ? \request()->get('min_price') : $this->productRepository->minPrice();
        $maxPrice = \request()->has('max_price') ? \request()->get('max_price') : $this->productRepository->maxPrice();
        $stock = \request()->has('stock') ? \request()->get('stock') : 0;
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ProductCollectionResource($this->productRepository->searchByPagination($sort, 'desc', $q, $special, $category, $attributes, $minPrice, $maxPrice, $stock, $brands, $page, $limit));
        } else {
            return new ProductCollectionResource($this->productRepository->search($sort, 'desc', $q, $special, $category, $attributes, $minPrice, $maxPrice, $stock, $brands));
        }
    }

    public function newestSpecials()
    {
        $sort = 1;
        $q = '';
        $special = 1;
        $category = \request()->has('category') ? \request()->get('category') : '';
        $brands = '';
        $attributes = '';
        $minPrice = $this->productRepository->minPrice();
        $maxPrice = $this->productRepository->maxPrice();
        $stock = 1;
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ProductCollectionResource($this->productRepository->searchByPagination($sort, 'desc', $q, $special, $category, $attributes, $minPrice, $maxPrice, $stock, $brands, $page, $limit));
        } else {
            return new ProductCollectionResource($this->productRepository->search($sort, 'desc', $q, $special, $category, $attributes, $minPrice, $maxPrice, $stock, $brands));
        }
    }

    public function ownLastProducts()
    {
        $ids = \request()->has('ids') ? \request()->get('ids') : '';
        return new ProductCollectionResource($this->productRepository->whereIn('id', explode(',', $ids))->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCreateRequest $request
     * @return ProductResource|JsonResponse
     */
    public function store(ProductCreateRequest $request)
    {
        DB::beginTransaction();
        try {
            $request['images'] = join(',', $request['images']);
            /** @var Product $product */
            $product = $this->productRepository->create($request->only([
                'title',
                'sub_title',
                'thumbnail',
                'description',
                'category_id',
                'quantity',
                'price',
                'images',
                'related_products',
                'special_price',
                'is_special',
                'special_start_date',
                'special_end_date',
            ]));
            $attributes = $request["attributes"];
            $error = $this->updateAttributes($product, $attributes);
            $this->updateRelatedProducts($product, $request["related_products"]);
            if ($error != "") {
                throw new \Exception($error);
            }
            DB::commit();
            return new ProductResource($product);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->createError('error', $exception->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return ProductResource
     */
    public function show(string $slug)
    {
        /** @var Product $product */
        $product = $this->productRepository->findBySlug($slug);
        $product->update([
            'seen' => $product->seen + 1,
        ]);
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     */
    public function update(ProductUpdateRequest $request, int $id)
    {
        DB::beginTransaction();
        try {
            /** @var Product $product */
            $product = $this->productRepository->findOneOrFail($id);
            if ($product == null) {
                return $this->createError('notfound', 'محصول پیدا نشد', 404);
            }
            $request['images'] = join(',', $request['images']);
            $this->productRepository->update($request->only([
                'title',
                'sub_title',
                'thumbnail',
                'description',
                'category_id',
                'quantity',
                'price',
                'images',
                'related_products',
                'special_price',
                'is_special',
                'special_start_date',
                'special_end_date',
            ]), $id);
            $deleted = $request["deleted_attributes"];
            $d = $product->attributes()->whereIn('id', $deleted)->detach();
            $product->attributeItems()->whereIn('attribute_id', $deleted)->delete();
            $attributes = $request["new_attributes"];
            $error = $this->updateAttributes($product, $attributes);
            if ($error != "") {
                throw new \Exception($error);
            }
            DB::commit();
            return new ProductResource($product);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->createError('error', $exception->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->productRepository->delete($id);
    }

    public function relatedProducts(int $id)
    {
        /** @var Product $product */
        $product = $this->productRepository->findOneOrFail($id);
        return new ProductCollectionResource($product->relatedProducts);
    }

    public function toggleFavourite(int $id)
    {
        /** @var Product $product */
        $product = $this->productRepository->findOneOrFail($id);
        $own = $this->getAuth();
        $own->toggleFavorite($product);
        return (bool)$own->hasFavorited($product);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function ownFavouriteProducts(): ProductCollectionResource
    {
        $own = $this->getAuth();
        if ($this->hasPage()) {
            $limit = $this->getLimit();
            $products = $own->getFavoriteItems(Product::class)->paginate($limit);
        } else {
            $products = $own->getFavoriteItems(Product::class)->get();
        }
        return new ProductCollectionResource($products);
    }

    private function updateAttributes(Product $product, array $attributes): string
    {
        try {
            foreach ($attributes as $attribute) {
                /** @var Attribute $attr */
                $product->attributes()->attach($attribute['id']);
                $items = $attribute["items"];

                foreach ($items as $item) {
                    $product->attributeItems()->create([
                        'name' => $item["name"],
                        'value' => $item["value"],
                        'price' => $item["price"],
                        'attribute_id' => $attribute["id"],
                    ]);
                }
            }
            return "";
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function updateRelatedProducts(Product $product, array $related_products)
    {
        $product->relatedProducts()->sync($related_products);
    }
}
