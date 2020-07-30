<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = [], $code = 200, $msg = '') {
        return response()->json($data)->setStatusCode($code, $msg);
    }

    public function error($msg, $code = 400, $data = [])
    {
        return response()->json($data)->setStatusCode($code, $msg);
    }
}
