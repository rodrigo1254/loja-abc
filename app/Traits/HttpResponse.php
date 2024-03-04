<?php

namespace App\Traits;

trait HttpResponse
{
    public function response($message, $status = [], $data = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'data' => $data
        ]);
    }  
    
    public function error($message, $status = [], $errors, $data = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'errors' => $errors,
            'data' => $data
        ],$status);
    } 
}