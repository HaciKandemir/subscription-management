<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

trait JsonResponseTrait
{
    /**
     * @throws ExceptionInterface
     */
    private function serialize($data): array
    {
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn ($object) => ['id' => $object->getId()]
        ]);

        $serializer = new Serializer([
            new DateTimeNormalizer(),
            $normalizer
        ]);

        return $serializer->normalize($data, null, [
            'datetime_format' => 'Y-m-d H:i:s',
            AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true
        ]);
    }

    /**
     * @param mixed $data
     * @return JsonResponse
     * @throws ExceptionInterface
     */
    protected function successResponse(mixed $data): JsonResponse
    {
        return $this->sendJsonResponse([
            'data' => $this->serialize($data),
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