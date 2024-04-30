<?php

namespace App\Service;

use App\Dto\Request\Register\RegisterDto;
use App\Entity\Device;
use App\Repository\DeviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class DeviceService
{
    private EntityManagerInterface $em;
    private DeviceRepository $deviceRepository;
    private ParameterBagInterface $params;

    public function __construct(EntityManagerInterface $em, DeviceRepository $deviceRepository, ParameterBagInterface $params)
    {
        $this->em = $em;
        $this->deviceRepository = $deviceRepository;
        $this->params = $params;
    }

    public function generateToken(): string
    {
        return sha1(uniqid($this->params->get('SECRET_KEY'), true));
    }

    public function findDevice(array $criteria): ?Device
    {
        return $this->deviceRepository->findOneBy($criteria);
    }

    public function createDevice(RegisterDto $registerDto): Device
    {
        $accessToken = $this->generateToken();

        $device = new Device();
        $device->setUId($registerDto->getUId());
        $device->setAppId($registerDto->getAppId());
        $device->setLanguage($registerDto->getLanguage());
        $device->setOperatingSystem($registerDto->getOperatingSystem());
        $device->setAccessToken($accessToken);

        $this->em->persist($device);
        $this->em->flush();

        return $device;
    }

    public function registerDevice(RegisterDto $registerDto): ?Device
    {
        $device = $this->findDevice(['uId' => $registerDto->getUId(), 'appId' => $registerDto->getAppId()]);

        if (!$device) {
            $device = $this->createDevice($registerDto);
        }

        return $device;
    }


}