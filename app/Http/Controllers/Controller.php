<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // response cover;
    protected function response_json(Array $data, string $message, $status = 200) {
        return response()->json(array_merge($data, ['message' => $message]), $status);
    }
}
