<?php

namespace App\Exceptions;


use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Error;
use Illuminate\Http\Response;
use League\OAuth2\Server\Exception\OAuthServerException;
use PhpAmqpLib\Exception\AMQPIOException;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
            //
        });
    }

    // public function render($request, Exception|Throwable $exception)
    // {

    //     // return response()->error(
    //     //     $exception->getMessage() ? $exception->getMessage() : "Unexpected Exception.Try later :( ",
    //     //     [],
    //     //     $exception->getCode() ? $exception->getCode() : 500
    //     // );
    // }
}
