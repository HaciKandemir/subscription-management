<?php

namespace App\Controller;

use App\Dto\Request\Register\RegisterDto;
use App\Service\RegisterService;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class RegisterController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * @throws ExceptionInterface
     */
    #[Route('/register', name: 'app_register')]
    public function register(RegisterDto $registerDto, RegisterService $registerService): JsonResponse
    {
        $device = $registerService->createDevice($registerDto);

        return $this->successResponse([
            'message'=>'register OK',
            'client-token'=>$device->getAccessToken()
        ]);
    }
}
