<?php

namespace App\Controller;

use App\Dto\Request\Register\RegisterDto;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    use JsonResponseTrait;

    #[Route('/register', name: 'app_register')]
    public function register(RegisterDto $registerDto): JsonResponse
    {

        return $this->successResponse([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RegisterController.php',
        ]);
    }
}
