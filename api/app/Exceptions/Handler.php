<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
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
    public function render($request, Throwable $exception): Response
    {
        if ($exception instanceof BaseException) {
            return new JsonResponse([
                'error' => [
                    'message' => $exception->getMessage(),
                    'code' => $exception->getCode()
                ]
            ]);
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception): Response
    {
        return new JsonResponse([
            'error' => [
                'message' => $exception->getMessage()
            ]
        ], JsonResponse::HTTP_UNAUTHORIZED);
    }

    protected function invalidJson($request, ValidationException $exception): JsonResponse
    {
        return new JsonResponse([
            'error' => [
                'message' => $exception->getMessage(),
                'validator' => $exception->errors()
            ]
        ], $exception->status);
    }

    protected function prepareJsonResponse($request, Throwable $e): JsonResponse
    {
        return new JsonResponse(
            ['error' => $this->convertExceptionToArray($e)],
            $this->isHttpException($e) ? $e->getStatusCode() : JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            $this->isHttpException($e) ? $e->getHeaders() : [],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }
}
