<?php

use App\User\Models\User;
use App\User\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthTest extends TestCase
{

    public function testLogin()
    {
        $email = (new UserRepository())
            ->findById(1)
            ->entity()
            ->getEmail();

        $this->post('/api/auth/login', [
            'email' => $email,
            'password' => 'pass'
        ]);

        $this->assertResponseOk();
        $this->assertArrayHasKey('access_token', json_decode($this->response->getContent(), true));
    }

    public function testLogout()
    {
        $token = JWTAuth::fromUser(User::find(1)->first());

        $this->post('/api/auth/logout', [], [
            'Authorization' => "Bearer ".$token
        ]);

        $this->assertResponseOk();
        $this->assertJsonStringEqualsJsonString('{"message":"Successfully logged out"}', $this->response->getContent());
    }
}
