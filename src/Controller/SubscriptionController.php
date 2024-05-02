<?php

namespace App\Controller;

use App\Dto\Request\Subscription\CheckRequestDto;
use App\Dto\Request\Subscription\PurchaseRequestDto;
use App\Dto\Response\Subscription\CheckResponseDto;
use App\Service\AccessTokenService;
use App\Service\SubscriptionService;
use App\Traits\JsonResponseTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/subscription')]
class SubscriptionController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * @throws ExceptionInterface
     */
    #[Route('/check', name: 'app_subscription_check', methods: 'POST')]
    public function check(CheckRequestDto $checkRequestDto, AccessTokenService $accessTokenService): JsonResponse
    {
        $accessToken = $accessTokenService->findByToken($checkRequestDto->clientToken);

        if (!$accessToken) {
            throw new BadRequestHttpException('Invalid clientToken');
        }

        $response = new CheckResponseDto();

        $subscription = $accessToken->getSubscription();

        if ($subscription) {
            $response->status = $subscription->getStatus();
            $response->expireDate = $subscription->getExpireAt();
        }

        return $this->successResponse($response);
    }

    /**
     * @throws ExceptionInterface
     * @throws \Exception
     */
    #[Route('/purchase', name: 'app_subscription_purchase', methods: 'POST')]
    public function purchase(PurchaseRequestDto $purchaseRequestDto, SubscriptionService $subscriptionService): JsonResponse
    {
        $subscription = $subscriptionService->purchase($purchaseRequestDto);

        $response = new CheckResponseDto();

        $response->status = $subscription->getStatus();
        $response->expireDate = $subscription->getExpireAt();

        return $this->successResponse($response);
    }
}
