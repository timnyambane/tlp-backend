<?php
namespace App\Helpers;
class ApiResponse
{
    public static function success($data = null, $message = 'Process completed', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public static function error($message = 'Error', $code = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    public static function unauthorized($message = 'Unauthorized')
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 401);
    }

    public static function forbidden($message = 'Forbidden')
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 403);
    }

    public static function notFound($message = 'Resource not found')
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 404);
    }

    public static function validation($errors, $message = 'Validation failed')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], 422);
    }

    public static function noContent()
    {
        return response()->json(null, 204);
    }

    public static function created($data = null, $message = 'Resource created')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], 201);
    }
}
