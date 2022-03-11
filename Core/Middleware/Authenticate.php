<?php

namespace Core\Middleware;

use App\User\Repositories\UserRepository;
use Closure;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
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
