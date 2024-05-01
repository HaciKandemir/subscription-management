<?php

namespace App\Service;

use App\Dto\Request\Register\RegisterDto;
use App\Entity\App;
use App\Entity\Device;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeviceService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly DeviceRepository $deviceRepository,
        private readonly ParameterBagInterface $params,
        private readonly SubscriptionService $subscriptionService
    )
    {}

    public function generateToken(): string
    {
        return sha1(uniqid($this->params->get('SECRET_KEY'), true));
    }

    public function findDevice(array $criteria): ?Device
    {
        return $this->deviceRepository->findOneBy($criteria);
    }

    private function findOrCreateDevice(RegisterDto $registerDto): Device
    {
        $device = $this->findDevice(['uId' => $registerDto->uId]);

        if (!$device) {
            $device = new Device();
            $device->setUId($registerDto->uId);
            $device->setLanguage($registerDto->language);
            $device->setOperatingSystem($registerDto->operatingSystem);

            $this->em->persist($device);
            $this->em->flush();
        }

        return $device;
    }

    public function registerDevice(RegisterDto $registerDto): string
    {
        $app = $this->em->getRepository(App::class)->find($registerDto->appId);

        if (!$app) {
            throw new BadRequestHttpException('Invalid appId');
        }

        $device = $this->findOrCreateDevice($registerDto);

        $clientToken = $this->generateToken();

        $subscription = $this->subscriptionService->findOrCreateSubscription($device, $app);
        $subscription->setClientToken($clientToken);
        $subscription->setUpdatedAt(new \DateTimeImmutable());

        $this->em->persist($subscription);
        $this->em->flush();

        return $clientToken;
    }
}