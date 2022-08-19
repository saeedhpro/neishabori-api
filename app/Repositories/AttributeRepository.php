<?php


namespace App\Repositories;

use App\Interfaces\AttributeInterface;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeRepository
 *
 * @package \App\Repositories
 */
class AttributeRepository extends BaseRepository implements AttributeInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function noneEmptyList()
    {
        return $this->model->query()->get()->filter(function($attribute) {
            /** @var Attribute $attribute */
            return $attribute->items()->count() > 0;
        });
    }
}
