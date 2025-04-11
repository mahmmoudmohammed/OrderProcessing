<?php

namespace App\Http\Domains\User\Repository;

use App\Http\Domains\User\Contract\AuthInterface;
use App\Http\Domains\User\Model\Merchant;
use App\Http\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class MerchantAuthRepository extends BaseRepository implements AuthInterface
{
    public function __construct(private Merchant $merchant)
    {
    }

    protected function model(): string
    {
        return $this->merchant::class;
    }

    // TODO:: implement Merchant Auth Logic
    public function register($data): Model
    {
        // TODO: Implement register() method.
    }

    public function login(array $data): Model|null
    {
        // TODO: Implement login() method.
    }
}
