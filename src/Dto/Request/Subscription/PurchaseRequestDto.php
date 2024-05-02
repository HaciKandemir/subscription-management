<?php

namespace App\Dto\Request\Subscription;

use App\Dto\DtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequestDto implements DtoInterface
{
    #[Assert\NotNull(message: 'message.client_token.not_null')]
    #[Assert\NotBlank(message: 'message.client_token.not_blank')]
    #[Assert\Type(type: 'string', message: 'message.client_token.invalid')]
    public string $clientToken;

    #[Assert\NotNull(message: 'message.receipt.not_null')]
    #[Assert\NotBlank(message: 'message.receipt.not_blank')]
    #[Assert\Type(type: 'string', message: 'message.receipt.invalid')]
    public string $receipt;
}