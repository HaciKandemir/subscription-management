<?php

namespace App\Dto\Request\Register;

use App\Dto\DtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterDto implements DtoInterface
{
    #[Assert\NotNull(message: 'message.u_id.not_null')]
    #[Assert\NotBlank(message: 'message.u_id.not_blank')]
    #[Assert\Type(type: 'string', message: 'message.u_id.invalid')]
    #[Assert\Length(max: 255, maxMessage: 'message.u_id.max')]
    public string $uId;

    #[Assert\NotNull(message: 'message.app_id.not_null')]
    #[Assert\NotBlank(message: 'message.app_id.not_blank')]
    #[Assert\Type(type: 'integer', message: 'message.app_id.invalid')]
    public int $appId;

    #[Assert\NotNull(message: 'message.language.not_null')]
    #[Assert\NotBlank(message: 'message.language.not_blank')]
    #[Assert\Type(type: 'string', message: 'message.language.invalid')]
    #[Assert\Length(max: 3, maxMessage: 'message.language.max')]
    public string $language;

    #[Assert\NotNull(message: 'message.operatingSystem.not_null')]
    #[Assert\NotBlank(message: 'message.operatingSystem.not_blank')]
    #[Assert\Type(type: 'string', message: 'message.operatingSystem.invalid')]
    #[Assert\Length(max: 50, maxMessage: 'message.operatingSystem.max')]
    public string $operatingSystem;
}