<?php

class CategoryTest extends TestCase
{

    public function testGetCategories()
    {
        $this->get('/api/category');

        $this->assertResponseOk();
        $this->assertArrayHasKey('data', json_decode($this->response->getContent(), true));
    }

    public function testGetCategory()
    {
        $this->get('/api/category/1');

        $this->assertResponseOk();
        $this->assertArrayHasKey('data', json_decode($this->response->getContent(), true));
    }
}
