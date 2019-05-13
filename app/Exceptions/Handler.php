<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // custom error message
        $trace = $exception->getTraceAsString();
        $message = __("There was an error.\nPlease contact administrator.");
        if ($exception instanceof QueryException || $exception instanceof \ErrorException) {
            if ($request->expectsJson() === true) {
                return response()->json(['success' => false, 'message' => $message, 'trace' => $trace], 500);
            }
            if (env('APP_ENV') == 'local') {
                return parent::render($request, $exception);
            }
            return response()->view('errors.500', 500);
        }
        if ($exception instanceof HttpException || $exception instanceof TokenMismatchException) {
            switch ($exception->getStatusCode()) {
                case 500:
                    if ($request->expectsJson() === true) {
                        return response()->json(['success' => false, 'message' => $message, 'trace' => $trace], 500);
                    }
                    if (env('APP_ENV') == 'local') {
                        return parent::render($request, $exception);
                    }
                    return response()->view('errors.500', 500);
                    break;
                case 404:
                    $message = __("The page your are looking for can not be found.");
                    if ($request->expectsJson() === true) {
                        return response()->json(['success' => false, 'message' => $message, 'trace' => $trace], 404);
                    }
                    if (env('APP_ENV') == 'local') {
                        return parent::render($request, $exception);
                    }
                    return response()->view('errors.404', 404);
                    break;
                case 401:
                    $message = __('Authentication failed.\nYou will be taken back to the login page for 5 seconds.');
                    if ($request->expectsJson() === true) {
                        return response()->json(['success' => false, 'message' => $message, 'trace' => $trace], 401);
                    }
                    return redirect()->guest(route('login'));
                    break;
                default:
                    if ($request->expectsJson() === true) {
                        return response()->json(['success' => false, 'message' => $message, 'trace' => $trace], 500);
                    }
                    return parent::render($request, $exception);
                    break;
            }
        }
        if ($request->expectsJson() === true) {
            return response()->json(['success' => false, 'message' => $message, 'trace' => $trace], 500);
        }
        return parent::render($request, $exception);
    }
}
