<?php

namespace App\Http\Repository;

use App\Http\Helpers\ApiDesignTrait;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseOperationsInterface
{
    use ApiDesignTrait;

    protected abstract function model(): string|Model;

    public function create(array $data): Model
    {
        return $this->model()::create($data);
    }

    public function load(Model $order, array|string $relations): Model
    {
        return $order->load($relations);
    }

}
