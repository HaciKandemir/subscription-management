<?php

namespace App\Controller\Exception;

use App\Traits\JsonResponseTrait;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionHandler
{
    use JsonResponseTrait;

    public function handle(\Throwable $exception): JsonResponse
    {
        $exceptionCode = 500;
        $message = $exception->getMessage();
        $decodedMessage = json_decode($message, true);
        $validations = [];

        if ($exception->getCode() > 0) {
            $exceptionCode = $exception->getCode();
        }

        if($decodedMessage !== null) {
            $message = $decodedMessage['message'];
            $validations = $decodedMessage['validations'];
        }

        return $this->errorResponse($message, $validations ,$exceptionCode);
    }
}