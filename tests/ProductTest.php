<?php

use App\Product\Repositories\ProductRepository;

class ProductTest extends TestCase
{

    public function testGetProducts()
    {
        $this->actingAs($this->getAuthUser())->get('/api/product');

        $this->assertResponseOk();
        $this->assertArrayHasKey('data', json_decode($this->response->getContent(), true));
    }

    public function testGetProduct()
    {
        $entity = (new ProductRepository())->where([
            'user_id' => $this->getAuthUser()->id
        ])->entity();

        $this->actingAs($this->getAuthUser())->get('/api/product/'.$entity->getId());

        $this->assertResponseOk();
        $this->assertArrayHasKey('data', json_decode($this->response->getContent(), true));
    }

    // Test you cannot get product that doesn't belong to authenticated user
    public function testCannotGetProductNotBelongingToYou()
    {
        $entity = (new ProductRepository())->whereOperator(
            'user_id', '!=', $this->getAuthUser()->id
        )->entity();

        $this->actingAs($this->getAuthUser())->get('/api/product/'.$entity->getId());

        $this->assertResponseStatus(403);
    }
}
