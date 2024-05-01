<?php

namespace App\Controller;

use App\Entity\Device;
use App\Service\DeviceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/check-subscription/{clientToken}', name: 'app_subscription', methods: 'GET')]
    public function check(string $clientToken, DeviceService $registerService): JsonResponse
    {
        $device = $registerService->findDevice(['accessToken' => $accessToken]);

        if (!$device) {
            throw new NotFoundHttpException('DeviceModelDto Not Found');
        }


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SubscriptionController.php',
        ]);
    }
}
