<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function show_all_products()
    {
        $response = $this->call('api/products');
        $this->assertEquals(200, $response->status());
    }
}
