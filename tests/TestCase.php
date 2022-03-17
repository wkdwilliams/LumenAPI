<?php

use App\User\Models\User;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    protected function getAuthUser()
    {
        return User::find(1);
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
