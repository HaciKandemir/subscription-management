<?php

namespace App\Service;

use App\Entity\AccessToken;
use App\Entity\App;
use App\Entity\Device;
use App\Repository\AccessTokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class AccessTokenService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AccessTokenRepository $accessTokenRepository
    )
    {

    }

    public function findOrCreate(Device $device, App $app): AccessToken
    {
        $accessToken = $this->accessTokenRepository->findOneBy(['device' => $device, 'app' => $app]);

        if (!$accessToken) {
            $accessToken = new AccessToken();
            $accessToken->setDevice($device);
            $accessToken->setApp($app);

            $this->em->persist($accessToken);
            $this->em->flush();
        }

        return $accessToken;
    }

    public function findByToken(string $token)
    {
        return $this->accessTokenRepository->findOneBy(['token' => $token]);
    }
}