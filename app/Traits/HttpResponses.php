<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses {
    protected function success($data, $message=null, $code=200): JsonResponse
    {
        return response()->json([
            'status' => 'Success',
            'data' => $data,
            'message' => $message,
        ], $code);
    }
    protected function fail($data, $message=null, $code): jsonResponse
    {
        return response()->json([
            'status' => 'Fail',
            'data' => $data,
            'message' => $message,
        ], $code);
    }
    protected function isAdmin($user): bool
    {
        if(!empty($user)){
            return $user->TokenCan('admin');
        }
        return false;
    }
}
