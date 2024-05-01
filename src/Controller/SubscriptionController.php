<?php

namespace App\Controller;

use App\Dto\Request\Subscription\CheckRequestDto;
use App\Dto\Response\Subscription\CheckResponseDto;
use App\Repository\AccessTokenRepository;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class SubscriptionController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * @throws ExceptionInterface
     */
    #[Route('/check-subscription', name: 'app_check_subscription', methods: 'POST')]
    public function check(CheckRequestDto $checkRequestDto, AccessTokenRepository $accessTokenRepository): JsonResponse
    {
        $accessToken = $accessTokenRepository->findOneBy(['token' => $checkRequestDto->clientToken]);

        if (!$accessToken) {
            throw new BadRequestHttpException('Invalid clientToken');
        }

        $response = new CheckResponseDto();

        $subscription = $accessToken->getSubscription();

        if ($subscription) {
            $response->status = $subscription->getStatus();
            $response->expireDate = $subscription->getExpireDateTime();
        }

        return $this->successResponse($response);
    }
}
