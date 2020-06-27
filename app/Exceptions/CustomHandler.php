<?php

namespace App\Exceptions;

use Error;
use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Client\ConnectionException;

class CustomHandler extends ExceptionHandler
{
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if($exception instanceof BindingResolutionException)
        {
            // Get the suspected class
            $targetClass = preg_split('/\\\/',$exception->getMessage());
            $targetClass = end($targetClass);
            $targetClass = str_replace(']','',$targetClass);

            return response()->view('errors.generic', [
                'message' => $targetClass
            ]);
        }

        if($exception instanceof ConnectionException)
        {
            return response()->view('errors.generic', [
                'message' => $exception->getMessage()
            ]);
        }

        if($exception instanceof Error)
        {
            $targetClass = preg_split('/\\\/',$exception->getMessage());
            $targetClass = end($targetClass);
            $targetClass = str_replace(']','',$targetClass);

            return response()->view('errors.generic', [
                'message' => $targetClass
            ]);
        }


        return parent::render($request, $exception);
    }
}
