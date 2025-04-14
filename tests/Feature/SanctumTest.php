<?php

namespace Tests\Feature;

use App\Http\Domains\User\Model\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SanctumTest extends TestCase
{

    public function test_orders_list_can_be_retrieved(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
        );

        $response = $this->get('/api/orders');

        $response->assertOk();
    }
}
