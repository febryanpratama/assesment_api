<?php

namespace App\Utils;


class ResponseCode {
    static function successGet($data, $messages){
        return response()->json([
            "statusCode" => 200,
            "messages" => $messages,
            "data" => $data ?? null
        ]);
    }
    static function successPost($data, $messages){
        return response()->json([
            "statusCode" => 201,
            "messages" => $messages,
            "data" => $data ?? null
        ]);
    }

    static function errorGet($data, $messages){
        return response()->json([
            "statusCode" => 404,
            "messages" => $messages,
            "data" => $data ?? null
        ]);
    }
    static function errorPost($data, $messages){
        return response()->json([
            "statusCode" => 400,
            "messages" => $messages,
            "data" => $data ?? null
        ]);
    }

    static function unauthorized($data, $messages){
        return response()->json([
            "statusCode" => 401,
            "data"=> [
                "messages" => $messages,
                "data" => $data ?? null
            ]
        ]);
    }
}