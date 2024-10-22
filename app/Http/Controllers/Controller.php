<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

interface BaseControllerInterface
{
    function sendValidationError($message, $errors);
    function sendResponseOk($message, $data);
    function sendResponseCreated($message, $data);
    function sendResponse($status, $message, $data, $status_code);
    function sendExceptionError($errors);
}

class Controller extends BaseController implements BaseControllerInterface
{
    use AuthorizesRequests, ValidatesRequests;

    function sendValidationError($message, $errors): Response
    {
        return response([
            'status' => false,
            'message' => $message,
            'errors' => $errors
        ], 200);
    }

    function sendResponseOk($message, $data): Response
    {
        return response([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    function sendResponseCreated($message, $data): Response
    {
        return response([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 201);
    }

    function sendResponse($status, $message, $data, $status_code): Response
    {
        return response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status_code);
    }

    function sendExceptionError($errors): Response
    {
        return response([
            'status' => false,
            'message' => "Internal server error. Please try again",
            'errors' => $errors
        ], 500);
    }
}

