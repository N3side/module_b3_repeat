<?php

namespace App\Traits;

trait ApiResponseTrait {
    public function validation($message="Validation error", $code=422, $errors=null) {
        $response = [
            "code" => $code,
            "message" => $message,
        ];

        if ($errors) {
            $response["errors"] = $errors;
        }

        return response()->json([
            "error" => $response
        ]);
    }

    public function forbidden() {
        return response()->json([
            "message" => "Forbidden for you",
            "code" => 403
        ], 403);
    }

    public function loginfailed() {
        return response()->json([
            "message" => "Login failed",
            "code" => 403
        ], 403);
    }

}
