<?php

namespace App\Service;

use App\Dto\Request\Subscription\PurchaseRequestDto;
use App\Entity\App;
use App\Entity\Device;
use App\Entity\Subscription;
use App\Enum\Device\OperatingSystem;
use App\Enum\Subscription\Status;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SubscriptionService
{
    public function __construct(
        private readonly  EntityManagerInterface $em,
        private readonly SubscriptionRepository $subscriptionRepository,
        private readonly AccessTokenService $accessTokenService
    )
    {

    }

    private function createSubscription(Device $device, App $app): Subscription
    {
        $subscription = new Subscription();
        $subscription->setDevice($device);
        $subscription->setApp($app);

        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }

    public function findOrCreateSubscription(Device $device, App $app): Subscription
    {
        $subscription = $this->subscriptionRepository->findOneBy(
            ['device' => $device, 'app' => $app],
            ['createdAt' => 'DESC']
        );

        if (!$subscription) {
            $subscription = $this->createSubscription($device, $app);
        }

        return $subscription;
    }

    /**
     * @throws \Exception
     */
    public function purchase(PurchaseRequestDto $purchaseRequestDto): Subscription
    {
        $accessToken = $this->accessTokenService->findByToken($purchaseRequestDto->clientToken);

        if (!$accessToken) {
            throw new BadRequestHttpException('Invalid clientToken');
        }

        $app = $accessToken->getApp();
        $device = $accessToken->getDevice();
        $subscription = $accessToken->getSubscription();

        if(OperatingSystem::tryFrom($device->getOperatingSystem()) === null) {
            throw new BadRequestHttpException('Unsupported operatingSystem');
        }

        if (
            $subscription &&
            $subscription->getStatus() === Status::ACTIVE &&
            $subscription->getExpireAt()->getTimestamp() >= time()
        ) {
            throw new BadRequestHttpException('Already have a active subscription');
        }

        //TODO: send approve request by device operatingSystem with app ios or google credentials
        $approveResult = $this->approveSimulation($purchaseRequestDto->receipt);

        if ($approveResult['status'] === false) {
            throw new BadRequestHttpException('Failed to approve subscription');
        }

        if (!$subscription) {
            $subscription = $this->createSubscription($device, $app);

            $accessToken->setSubscription($subscription);

            $this->em->persist($accessToken);
        } else {
            $subscription->setUpdatedAt(new \DateTimeImmutable());
        }

        $subscription->setExpireAt(new \DateTimeImmutable($approveResult['expireDate']));
        $subscription->setStatus(Status::ACTIVE);

        $this->em->persist($subscription);
        $this->em->flush();

        return $subscription;
    }

    private function approveSimulation(string $receipt): array
    {
        $lastCharacter = substr($receipt, -1);


        if (ctype_digit($lastCharacter) && $lastCharacter % 2 !== 0) {
            $expireDate = new \DateTime();
            // P1M => +1 month
            $expireDate->add(new \DateInterval('P1M'));

            return [
                'status' => true,
                'expireDate' => $expireDate->format('Y-m-d H:i:s')
            ];
        }

        return ['status' => false];

    }
}