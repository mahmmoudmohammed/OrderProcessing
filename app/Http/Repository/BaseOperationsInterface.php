<?php

namespace App\Http\Repository;

use Illuminate\Database\Eloquent\Model;

interface BaseOperationsInterface
{
    public function create(array $data): Model;

    public function load(Model $order, array|string $relations): Model;
}
