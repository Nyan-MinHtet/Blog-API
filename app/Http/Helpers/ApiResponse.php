<?php

namespace App\Http\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;
use InvalidArgumentException;

trait ApiResponse{
    protected function successResponse($message='success', $content=null, $status=200){
        return response()->json([
            'success' => true,
            'message' => $message,
            'content' => $content,
            'status' => $status
        ], $status);
    }


    public function BadRequestErrorResponse($message = null, $status = 400, $errors = null){
        return $this->errorResponse($message, $status, $errors);
    }
    protected function errorResponse($message='bad request', $status = 400, $errors = null){
        
        $response = [
            'success' => false,
            'message' => $message,
            'status' => $status,
        ];
        if($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    protected function buildPaginatedResponse(string $resource, LengthAwarePaginator $collections): array 
    {
        if (!is_subclass_of($resource, JsonResource::class)) {
            throw new InvalidArgumentException(sprintf('%s must be a child class of %s', $resource, JsonResource::class));
        }
        return [
            "data"   => $resource::collection($collections),
            "links"  => [
                            "prev"     => $collections->previousPageUrl(),
                            "next"     => $collections->nextPageUrl()
                        ],
            "meta"   => [
                            "current_tab"  => $collections->currentPage(),
                            "last_tab"     => $collections->lastPage(),
                            "from"          => $collections->firstItem(),
                            "to"            => $collections->lastItem(),
                            "path"          => "http://api/v1/",
                            "per_page"      => $collections->perPage(),
                            "total"         => $collections->total()
                        ]
        ];
    }
}

