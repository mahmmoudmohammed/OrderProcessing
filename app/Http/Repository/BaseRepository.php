<?php

namespace App\Http\Repository;

use App\Http\Helpers\ApiDesignTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public static function paginationLimit($perPage, $minPerPage = 5, $maxPerPage = 100)
    {
        return max($minPerPage, min($maxPerPage, $perPage));
    }

    /**
     * Get paginated list of Model.
     *
     */
    public function list(?Builder $builder = null): LengthAwarePaginator
    {
        $model  = $this->model();
        $query  = $builder ?? (new $model)->newQuery();
        return $query->paginate($this::paginationLimit(request('per_page', config('app.pagination'))));
    }


}
