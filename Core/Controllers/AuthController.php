<?php

namespace Core\Controllers;

use App\User\Repositories\UserRepository;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    private Request $request;

    function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function login()
    {
        $user = (new UserRepository())
                ->where(['email' => $this->request->email])
                ->entity();
        
        if(Hash::check($this->request->password, $user->getPassword()))
            return response()->json([
                'status'    => 200,
                'token'     => $user->getApiToken()
            ], 200);
        
        return response()->json([
            'status'    => 401,
            'message'   => "Incorrect email or password"
        ], 401);
    }
}