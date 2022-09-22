<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Carbon\CarbonInterval;
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
        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry')) {
                $this->sentryID = app('sentry')->captureException($e);
            }
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if (config('app.env') == 'local') {
            return parent::render($request, $exception);
        }

        if ($this->isHttpException($exception)) {
            $status_code = $exception->getStatusCode();
            if ($status_code == '404') {
                return parent::render($request, $exception);
            }
        }

        if ($exception instanceof ThrottleRequestsException) {
            $retryAfter = $exception->getHeaders()['Retry-After'];
            $humanTime = CarbonInterval::seconds($retryAfter)->cascade()->forHumans();
            return response([
                'status'  => false,
                'message' => 'Please try again in '. $humanTime,
            ], 429);
        }

        if ($exception->getCode() == 401) {
            return response([
                'status'  => false,
                'message' => $exception->getMessage(),
            ], 401);
        }
        $this->sentryID = app('sentry')->captureException($exception);

        return response([
            'status'   => false,
            'message'  => '',
            'sentryId' => $this->sentryID,
        ], 500);
    }
}
