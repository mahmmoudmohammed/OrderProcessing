<?php

namespace Tests\Unit;

use App\Http\Domains\Order\Service\OrderValidatorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class OrderValidatorServiceTest extends TestCase
{
    use RefreshDatabase;

    protected OrderValidatorService $orderValidatorService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderValidatorService = new OrderValidatorService();
    }

    /** @test */
    public function it_throws_internal_exception_when_ingredient_qty_not_sufficient()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function it_throws_internal_exception_when_product_not_active()
    {
        $this->markTestIncomplete();
    }

}
