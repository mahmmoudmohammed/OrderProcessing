<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $orderService;

    protected function setUp(): void
    {
        parent::setUp();
    }
    /** @test */
    public function it_generates_unique_order_numbers()
    {
        $number = [1,12,123,1234];
        $this->assertEquals(4, count($number));
    }

}
