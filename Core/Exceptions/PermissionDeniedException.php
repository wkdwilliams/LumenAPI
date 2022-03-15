<?php

namespace Core\Exceptions;

use Exception;

class PermissionDeniedException extends Exception
{

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request){
        return response()->json([
            'status'  => 403,
            'message' => "Permission Denied.",
        ], 403);
    }
}