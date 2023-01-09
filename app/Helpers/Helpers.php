<?php

if (!function_exists('httpResponseStatus')) {
    /**
     * @param int $statusCode
     */
    function statusCode(int $statusCode): string
    {
        return [
            200 => 'OK',
            201 => 'Created',
            400 => 'Bad Request',
            401 => 'Unauthenticated',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            422 => 'Unprocessable Content',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
        ][$statusCode];
    }
}

if (!function_exists('resJson')){
    function resJson($data = [], $statusCode = 200, $headers = []): \Illuminate\Http\JsonResponse
    {
        if ($statusCode >= 200 && $statusCode < 400) {
            return response()->json([
                'message'   => $data['message'] ?? statusCode($statusCode),
                'data'      => $data['data']    ?? [],
            ], $statusCode);
        } else if ($statusCode >= 400 && $statusCode < 500) {
            return response()->json([
                'message'  => $data['message']  ?? statusCode($statusCode),
                'errors'   => $data['errors']   ?? [],
            ], $statusCode);
        } else {
            return response()->json([
                'message'  => $data['message']  ?? statusCode($statusCode),
            ], $statusCode);
        }
    }
}

if (!function_exists('arrayToObject')){
    function arrayToObject(string $message, int $status, mixed $data = null): object
    {
        return (object) [
            'message' => $message,
            'status' => $status,
            'data' => $data,
        ];
    }
}
