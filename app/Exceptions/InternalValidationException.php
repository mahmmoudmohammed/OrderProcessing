<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InternalValidationException extends Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }

    public static function make($message): static
    {
        return new self($message);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'errors'  => [],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
