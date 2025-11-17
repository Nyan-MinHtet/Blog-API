<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleCheckMiddleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Helpers\Exception\Handler\ApiExceptionResponseHelper;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role.check' => RoleCheckMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        function apiResponse(ApiExceptionResponseHelper $response, $message, $status, $error = null){
            return $response->BadRequestErrorResponse($message, $status, $error);
        }

        //Authorize
        $exceptions->render(function(AccessDeniedHttpException $accessDeniedHttpException, Request $request){
            if ($request->is('api/*')) {
                return apiResponse(new ApiExceptionResponseHelper, $accessDeniedHttpException->getMessage(), 403);
            }
        });
        //ModelNotFoundException 
        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, Request $request) 
        {
            if ($request->is('api/*')) {
                return apiResponse(new ApiExceptionResponseHelper, 'Content not found.', 404);
            }
            return null;
        });
    })->create();
