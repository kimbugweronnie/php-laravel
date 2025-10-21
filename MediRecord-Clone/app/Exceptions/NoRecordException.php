<?php

namespace App\Exceptions;

use Exception;

class NoRecordException extends Exception
{
    public function report()
    {
        $status = 400;
        $error = "No data found";
        return response(["error" => $error], $status);
    }
    
    // public function render($request, Throwable $exception)
    // {
    // if ($exception instanceof NoRecordException) {
    //     $status = 400;
    //     $error = "No data found";
    //     return response(["error" => $error], $status);
    // }
    // return parent::render($request, $exception);
}

