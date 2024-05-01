<?php

namespace App\Service;

use App\Entity\App;
use App\Entity\Device;
use App\Entity\Subscription;
use App\Repository\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class SubscriptionService
{
    private EntityManagerInterface $em;
    private SubscriptionRepository $subscriptionRepository;

    public function __construct(EntityManagerInterface $em, SubscriptionRepository $subscriptionRepository)
    {
        $this->em = $em;
        $this->subscriptionRepository = $subscriptionRepository;
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
}