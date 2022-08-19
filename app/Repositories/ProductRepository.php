<?php


namespace App\Repositories;


use App\Interfaces\ProductInterface;
use App\Models\AttributeItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductRepository extends BaseRepository implements ProductInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findBySlug(string $slug)
    {
        return $this->findOneByOrFail([
            'slug' => $slug
        ]);
    }

    public function maxPrice()
    {
        return $this->model->query()->max('price');
    }

    public function minPrice()
    {
        return $this->model->query()->min('price');
    }

    public function searchByPagination(int $sort, string $sortBy, string $q, int $isSpecial, string $category, string $attributes, $min_price, $max_price, $stock, $brands, int $page = 1, int $limit = 10)
    {
        $collection = $this->searchQuery($sort, $sortBy, $q, $isSpecial, $category, $attributes, $min_price, $max_price, $stock, $brands)->get();
        return $collection->filter(function($product) use($attributes) {
            if ($attributes) {
                $values = AttributeItem::query()->whereIn('id', explode(',', $attributes))->pluck('value')->toArray();
                /** @var Product $product */
                return $product->attributeItems()->count() > 0 && $product->attributeItems()->whereIn('value', $values);
            } else {
                return true;
            }
        })->paginate($limit);
    }

    public function search(int $sort, string $sortBy, string $q, int $isSpecial, string $category, string $attributes, $min_price, $max_price, $stock, string $brands)
    {
        $collection = $this->searchQuery($sort, $sortBy, $q, $isSpecial, $category, $attributes, $min_price, $max_price, $stock, $brands)->get();
        return $collection->filter(function($product) use($attributes) {
            if ($attributes) {
                $values = AttributeItem::query()->whereIn('id', explode(',', $attributes))->pluck('value')->toArray();
                /** @var Product $product */
                return $product->attributeItems()->count() > 0 && $product->attributeItems()->whereIn('value', $values);
            } else {
                return true;
            }
        });
    }

    private function searchQuery(int $sort, string $sortBy, string $q, int $isSpecial, string $category, string $attributes, $min_price, $max_price, $stock, $brands)
    {
        $query = $this->model->query()->leftJoin('order_items as o', 'products.id', '=', 'o.product_id');
        $query = $query->selectRaw('products.*, COALESCE(sum(o.quantity), 0) as sell')->groupBy('id');
        $query = $query->where(function ($query) use ($q) {
            $query->where('title', 'like', "%$q%")
                ->orWhere('description', 'like', "%$q%");
        });
        $orderBy = 'id';
        switch ($sort) {
            case 1:
                $orderBy = 'sell';
                $sortBy = 'desc';
                break;
            case 2:
                $orderBy = 'seen';
                break;
            case 3:
                $orderBy = 'created_at';
                break;
            case 4:
                $orderBy = 'price';
                $sortBy = 'asc';
                break;
            case 5:
                $orderBy = 'price';
                $sortBy = 'desc';
                break;
        }
        if ($category) {
            $query = $query->whereIn('category_id', explode(',', $category));
        }
        if ($brands) {
            $query = $query->whereIn('brand_id', explode(',', $brands));
        }
        if ($min_price) {
            $query = $query->where('price', '>=', $min_price);
        }
        if ($max_price) {
            $query = $query->where('price', '<=', $max_price);
        }
        switch ($isSpecial) {
            case 0:
                $query = $query->where('is_special', '=', false);
                break;
            case 1:
                $query = $query->where('is_special', '=', true)
                    ->where('special_start_date', '<=', Carbon::now())
                    ->where('special_end_date', '>=', Carbon::now());
                break;
        }
        if ($stock == 1) {
            $query = $query->where('products.quantity', '>', 0);
        }
        return $query->orderBy($orderBy, $sortBy);
    }

    public function whereIn(string $column, array $ids): Builder
    {
        return $this->model->query()->whereIn($column, $ids);
    }
}
