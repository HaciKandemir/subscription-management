<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;

trait JsonResponseTrait
{
    /**
     * @param mixed $data
     * @return JsonResponse
     */
    protected function successResponse(mixed $data): JsonResponse
    {
        return $this->sendJsonResponse([
            'data' => $data,
            'status' => [
                'success' => true,
            ]
        ], 200);
    }

    /**
     * @param string $message
     * @param array|null $validations
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse(string $message, ?array $validations = null, int $statusCode = 422): JsonResponse
    {
        return $this->sendJsonResponse([
            'status' => [
                'success' => false,
                'message' => $message,
                'validations' => $validations ?? []
            ]
        ], $statusCode);
    }

    /**
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    private function sendJsonResponse(mixed $data, int $statusCode): JsonResponse
    {
        return new JsonResponse($data, $statusCode);
    }
}