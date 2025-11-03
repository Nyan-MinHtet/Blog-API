<?php

namespace App\Http\Helpers;

trait ApiResponse{
    protected function successResponse($message='success', $content=null, $status=200){
        return response()->json([
            'success' => true,
            'message' => $message,
            'content' => $content,
            'status' => $status
        ], $status);
    }

    /**
     * UPDATED to accept a new '$errors' parameter.
     * This allows us to send back validation errors.
     */
    protected function errorResponse($message='bad request', $status=400, $errors = null){
        
        // Start with the basic error response
        $response = [
            'success' => false,
            'message' => $message,
            'status' => $status,
        ];

        // If an '$errors' array is provided, add it to the response.
        if($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}

