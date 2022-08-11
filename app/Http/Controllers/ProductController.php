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
        if ($this->hasPage()) {
            $page = $this->getPage();
            $limit = $this->getLimit();
            return new ProductCollectionResource($this->productRepository->allByPagination('*', 'id', 'DESC', $page, $limit));
        } else {
            return new ProductCollectionResource($this->productRepository->all());
        }
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
        return new ProductResource($this->productRepository->findBySlug($slug));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return mixed
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
            $delete = $product->attributes()->whereIn('id', $deleted)->delete();
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
        return (bool) $own->hasFavorited($product);
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
                $attr = $product->attributes()->create([
                    'name' => $attribute["name"],
                    'type' => $attribute["type"],
                    'category' => $attribute["category"],
                ]);
                $items = $attribute["items"];

                foreach ($items as $item) {
                    $attr->items()->create([
                        'name' => $item["name"],
                        'value' => $item["value"],
                        'price' => $item["price"],
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
