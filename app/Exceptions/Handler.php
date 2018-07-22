<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Asm89\Stack\CorsService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class Handler extends ExceptionHandler
{

    use ApiResponser;
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $response = $this->handleException($request, $exception);
        app(CorsService::class)->addActualRequestHeaders($response, $request);

        return $response;

    }

    public function handleException($request, Exception $exception) {


        if($exception instanceof ValidationException) {
            return $this->convertValidationExceptionToResponse($exception, $request);
        }

        if($exception instanceof ModelNotFoundException) {

            $modelName = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse("Does not exists any {$modelName} with the specified identifier",
                                        Response::HTTP_NOT_FOUND);
        }

        if($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }
//        if($exception instanceof AuthenticationException) {
//            return $this->errorResponse($exception->getMessage(), Response::HTTP_FORBIDDEN);
//        }

        if($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified URL cannot be found',
                Response::HTTP_NOT_FOUND);
        }
        if($exception instanceof MethodNotAllowedHttpException) {
            return $this->errorResponse('The specified method for the request is invalid',
                Response::HTTP_METHOD_NOT_ALLOWED);
        }
        if($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(),
                $exception->getStatusCode());
        }
        if ($exception instanceof QueryException) {
//            dd($exception);
            $errorCode = $exception->errorInfo[1];

            if($errorCode == 1451) {
                return $this->errorResponse('Cannot remove this entity permanently. The entity is related to other entity',
                    Response::HTTP_CONFLICT);
            }
        }

        if($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->input());
        }

        if(config('app.debug')) {
            return parent::render($request, $exception);
        } else {
            return $this->errorResponse('Unexpected Exception. Try later',
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }





    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($this->isFrontend($request)) {
            return redirect()->guest('login');
        }

        return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Create a response object from the given validation exception.
     *
     * @param  \Illuminate\Validation\ValidationException  $e
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
//        if ($e->response) {
//            return $e->response;
//        }
//
//        return $request->expectsJson()
//            ? $this->invalidJson($request, $e)
//            : $this->invalid($request, $e);

        $errors = $e->validator->errors()->getMessages();

        if($this->isFrontend($request)) {
            return $request->ajax() ? response()->json($errors, 422) : redirect()
                            ->back()
                            ->withInput($request->input())
                            ->withErrors($errors);
        }

        return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function isFrontend($request) {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
