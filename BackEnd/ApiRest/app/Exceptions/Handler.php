<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
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
    public function render($request, Throwable $exception)
    {
        if($exception instanceof QueryException){
            return $this->queryExceptionResponse($exception);
        } else if($exception instanceof ModelNotFoundException){
            return $this->modelNotFoundExceptionResponse($exception);
        }
        return parent::render($request, $exception);
    }

    public function queryExceptionResponse(QueryException $exception){
        if($exception->getCode() == 23000){
            return response()->json([
                'SQLSTATE' => $exception->getCode(),
                'message' => 'the resource is currently being used.',
                'DBMessage' => $exception->getMessage()
            ], 500);
        }
        return response()->json([
            'SQLSTATE' => $exception->getCode(),
            'message' => 'DataBase Error.',
            'DBMessage' => $exception->getMessage()
        ], 500);
    }

    public function modelNotFoundExceptionResponse(ModelNotFoundException $exception){
        return response()->json([
            'message' => 'Resource not found.',
            'infoMessage' => $exception->getMessage()
        ], 404);
    }
}
