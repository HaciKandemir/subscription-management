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
    private string $uId;

    #[Assert\NotNull(message: 'message.app_id.not_null')]
    #[Assert\NotBlank(message: 'message.app_id.not_blank')]
    #[Assert\Type(type: 'integer', message: 'message.app_id.invalid')]
    private int $appId;

    #[Assert\NotNull(message: 'message.language.not_null')]
    #[Assert\NotBlank(message: 'message.language.not_blank')]
    #[Assert\Type(type: 'string', message: 'message.language.invalid')]
    #[Assert\Length(max: 3, maxMessage: 'message.language.max')]
    private string $language;

    #[Assert\NotNull(message: 'message.operatingSystem.not_null')]
    #[Assert\NotBlank(message: 'message.operatingSystem.not_blank')]
    #[Assert\Type(type: 'string', message: 'message.operatingSystem.invalid')]
    #[Assert\Length(max: 50, maxMessage: 'message.operatingSystem.max')]
    private string $operatingSystem;

    public function getUId(): string
    {
        return $this->uId;
    }

    public function setUId(string $uId): void
    {
        $this->uId = $uId;
    }

    public function getAppId(): int
    {
        return $this->appId;
    }

    public function setAppId(int $appId): void
    {
        $this->appId = $appId;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    public function getOperatingSystem(): string
    {
        return $this->operatingSystem;
    }

    public function setOperatingSystem(string $operatingSystem): void
    {
        $this->operatingSystem = $operatingSystem;
    }
}