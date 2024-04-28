<?php

namespace App\Dto\Request\Register;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterDto
{
    #[Assert\NotBlank(message: 'message.u_id.not_blank')]
    #[Assert\NotNull(message: 'message.u_id.not_null')]
    #[Assert\Type(type: 'string', message: 'message.u_id.invalid')]
    #[Assert\Length(max: 255, maxMessage: 'message.u_id.max')]
    public string $uId;

    #[Assert\NotBlank(message: 'message.app_id.not_blank')]
    #[Assert\NotNull(message: 'message.app_id.not_blank')]
    #[Assert\Type(type: 'integer', message: 'message.app_id.invalid')]
    public int $appId;

    #[Assert\NotBlank(message: 'message.language.not_blank')]
    #[Assert\NotNull(message: 'message.language.not_null')]
    #[Assert\Type(type: 'string', message: 'message.language.invalid')]
    #[Assert\Length(max: 3, maxMessage: 'message.language.max')]
    public string $language;

    #[Assert\NotBlank(message: 'message.operatingSystem.not_blank')]
    #[Assert\NotNull(message: 'message.operatingSystem.not_null')]
    #[Assert\Type(type: 'string', message: 'message.operatingSystem.invalid')]
    #[Assert\Length(max: 50, maxMessage: 'message.operatingSystem.max')]
    public string $operatingSystem;

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