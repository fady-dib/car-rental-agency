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

        public function store_file($link, $request_file)
    {
        $tmp_file = $request_file;
        $tmp_file_name = basename($tmp_file->getClientOriginalName(), '.'.$tmp_file->getClientOriginalExtension());
        $tmp_file_name = strtolower(str_replace(" ", "-", $tmp_file_name));
        $tmp_file_extension = $tmp_file->getClientOriginalExtension();
        $original_name = $tmp_file_name . "-" . rand() . "." . $tmp_file_extension;

        if (config('filesystems.default') === 's3') {  
            Storage::disk('s3')->put('/storage/' . $link . '/' . $original_name, file_get_contents($tmp_file));
        } else {
            $tmp_file->storeAs('public/'.$link, $original_name);
        }

        $file_path = '/storage/' . $link . '/' . $original_name;

        return $file_path;
    }
}
