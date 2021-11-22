<?php

namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Responder Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponder
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, string $message = null, int $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $message,
        ], $code);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failure(string $message = null, int $code = 200, $data = null)
    {
        return response()->json([
            'status' => 'failure',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

}
