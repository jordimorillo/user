<?php

declare(strict_types=1);

namespace Source\User\Application\Command;

use Source\Shared\CQRS\CommandBus\Command;

class ChangePasswordCommand implements Command
{
    private string $email;
    private string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }
}
