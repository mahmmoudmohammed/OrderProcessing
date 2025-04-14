<?php

namespace App\Http\Helpers;

use App\Exceptions\InternalValidationException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiDesignTrait
{
    /**
     * @throws InternalValidationException
     */
    public function throwValidationException(string $message): void
    {
        throw InternalValidationException::make($message);
    }

    public function success(): JsonResponse
    {
        return response()->json(['message' => 'operation successful'], Response::HTTP_OK);
    }

    public function error($message, $status = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json(compact('message'), $status);
    }

    /**
     * Response with normal json array.
     *
     * @param int $code
     * @param null $message
     * @param null $data
     * @return JsonResponse
     */
    public function ApiResponse(int $code = 200, $message = null, $data = null): JsonResponse
    {
        $array = [
            'status' => $code,
            'message' => $message,
        ];

        if ($data)
            $array['message'] = $data;

        return response()->json($array, $code);
    }

    /**
     * Response with resource.
     *
     * @param mixed $resource
     * @param array|null $additional
     * @param integer $status
     *
     * @return mixed
     */
    public function responseResource(object $resource, array $additional = null, int $status = 200): mixed
    {
        if ($additional) {
            $resource->additional($additional);
        }
        return $resource->response()
            ->setStatusCode($status);
    }
}

