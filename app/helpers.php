<?php

if (!function_exists('successResponse')) {
   function successResponse($data = [], $message = 'Request was successful.', $statusCode = 200)
   {
       return response()->json([
           'status' => 'success',
           'data' => $data,
           'message' => $message,
           'meta'=> [
                'code' => $statusCode,
           ]
       ], $statusCode);
   }
}

if (!function_exists('errorResponse')) {
   function errorResponse($message = 'An error occurred.', $statusCode = 400)
   {
       return response()->json([
           'status' => 'error',
           'message' => $message,
           'meta'=> [
                'code' => $statusCode,
           ]
       ], $statusCode);
   }
}
