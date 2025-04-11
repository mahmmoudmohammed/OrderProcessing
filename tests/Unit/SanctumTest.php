<?php

namespace Tests\Unit;

use App\Http\Domains\User\Model\User;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class SanctumTest extends TestCase
{

    public function test_orders_list_can_be_retrieved(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['view-tasks']
        );

        $response = $this->get('/api/orders');

        $response->assertOk();
    }
}
