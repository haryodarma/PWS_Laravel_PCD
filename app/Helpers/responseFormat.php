<?php

namespace App\Helpers;

class ResponseFormat
{
    public static function success($status, $message, $data = null)
    {

        $res = [
            'status' => 200,
            'message' => $message,
            'data' => $data
        ];
        return response()->json($res);
    }
    public static function serverError($message = null)
    {
        $res = [
            'status' => 505,
            'message' => "Internal Server Error",
        ];
        if ($message) {
            $res['message'] = $message;
        }

        return response()->json($res);
    }
    public static function notFound()
    {
        $res = [
            'status' => 404,
            'message' => "Data Is Not Found",
        ];
        return response()->json($res);
    }

    public static function badRequest($message)
    {
        $res = [
            'status' => 400,
            'message' => $message,
        ];
        return response()->json($res);
    }
    public static function unauthorized($message)
    {
        $res = [
            'status' => 401,
            'message' => $message,
        ];
        return response()->json($res);
    }
}