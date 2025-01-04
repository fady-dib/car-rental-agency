<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function return_error($debugger, $code, $message)
    {
        $error['error'] = [];
        $error['error']['debugger'] = $debugger;
        $error['error']['code'] = $code;
        $error['error']['message'] = $message;

        return response()->json($error)->setStatusCode(400);
    }
}
