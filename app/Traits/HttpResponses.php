<?php

namespace App\Traits;

trait HttpResponses {
    protected function succsess($data, $message=null, $code=200) 
    {
        return response()->json([
            'status' => 'Succsess',
            'data' => $data,
            'message' => $message,
        ], $code);
    }
    protected function fail($data, $message=null, $code) 
    {
        return response()->json([
            'status' => 'Fail',
            'data' => $data,
            'message' => $message,
        ], $code);
    }
}