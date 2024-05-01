<?php

namespace App\Dto\Response\Subscription;

use DateTime;

class CheckResponseDto
{
    private string $status;

    private ?string $expireDate;

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @throws \Exception
     */
    public function getExpireDate(): ?string
    {
        $dateTime = new DateTime($this->expireDate);
        return $dateTime->format('Y-m-d\TH:i:s');
    }

    public function setExpireDate(?string $expireDate): void
    {
        $this->expireDate = $expireDate;
    }

}