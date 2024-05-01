<?php

namespace App\Dto\Response\Subscription;

use App\Dto\DtoInterface;

class CheckResponseDto implements DtoInterface
{
    public ?string $status = null;

    public ?\DateTimeInterface $expireDate = null;
}