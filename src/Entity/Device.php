<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $uId = null;

    #[ORM\Column]
    private ?int $appId = null;

    #[ORM\Column(length: 3)]
    private ?string $language = null;

    #[ORM\Column(length: 50)]
    private ?string $operatingSystem = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accessToken = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUId(): ?string
    {
        return $this->uId;
    }

    public function setUId(string $uId): static
    {
        $this->uId = $uId;

        return $this;
    }

    public function getAppId(): ?int
    {
        return $this->appId;
    }

    public function setAppId(int $appId): static
    {
        $this->appId = $appId;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->operatingSystem;
    }

    public function setOperatingSystem(string $operatingSystem): static
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(?string $accessToken): static
    {
        $this->accessToken = $accessToken;

        return $this;
    }
}
