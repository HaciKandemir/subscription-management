<?php

namespace App\Entity;

use App\Repository\AppRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Subscription>
     */
    #[ORM\OneToMany(targetEntity: Subscription::class, mappedBy: 'app')]
    private Collection $subscriptions;

    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Subscription>
     */
    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function addSubscription(Subscription $subscription): static
    {
        if (!$this->subscriptions->contains($subscription)) {
            $this->subscriptions->add($subscription);
            $subscription->setApp($this);
        }

        return $this;
    }

    public function removeSubscription(Subscription $subscription): static
    {
        if ($this->subscriptions->removeElement($subscription)) {
            // set the owning side to null (unless already changed)
            if ($subscription->getApp() === $this) {
                $subscription->setApp(null);
            }
        }

        return $this;
    }
}
