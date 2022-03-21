<?php

namespace Core\Exceptions;

use Exception;

class InvalidIdException extends Exception
{

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request){
        return response()->json([
            'status'  => 500,
            'message' => "Invalid id provided.",
        ], 404);
    }
}