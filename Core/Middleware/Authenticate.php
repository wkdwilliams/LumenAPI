<?php

namespace Core\Middleware;

use App\User\Repositories\UserRepository;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $apiToken = $request->header('Authorization');

        if($apiToken === null)
            return response('Unauthorized.', 401);
        
        $user = (new UserRepository())
                ->where(['api_token' => $apiToken]);

        if($user->count() == 0)
            return response('Unauthorized.', 401);

        return $next($request);
    }
}
