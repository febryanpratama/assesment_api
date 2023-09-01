<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (MethodNotAllowedHttpException $e) {
                // do something
                return response()->json([
                    'statusCode' => 405,
                    'message' => 'Resource not Allowed',
                    'data' => null
                ]);
            });
    }
    public function render($request, Throwable $e)
    {
         if ($e instanceof MethodNotAllowedHttpException) {
        if ($request->ajax()) {
            return response()->json(['error' => 'Route Not Found'], 404);
        }
        else {
            //something else
        }
    }

    return parent::render($request, $e);
    }
}

