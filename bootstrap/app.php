<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleCheckMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Helpers\Exception\Handler\ApiExceptionResponseHelper;




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

        //ModelNotFoundException 
        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $e, Request $request) 
        {
            $response = new ApiExceptionResponseHelper();
            if ($request->is('api/*')) {
                return $response->BadRequestErrorResponse(
                    "Content Not found!",
                    404
                );
            }
            return null;
        });
    })->create();
