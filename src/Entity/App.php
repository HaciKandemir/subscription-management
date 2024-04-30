<?php

namespace App\Entity;

use App\Repository\AppRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppRepository::class)]
class App
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $iosCredential = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $googleCredential = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIosCredential(): ?string
    {
        return $this->iosCredential;
    }

    public function setIosCredential(?string $iosCredential): static
    {
        $this->iosCredential = $iosCredential;

        return $this;
    }

    public function getGoogleCredential(): ?string
    {
        return $this->googleCredential;
    }

    public function setGoogleCredential(?string $googleCredential): static
    {
        $this->googleCredential = $googleCredential;

        return $this;
    }
}
