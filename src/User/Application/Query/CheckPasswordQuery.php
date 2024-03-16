<?php

declare(strict_types=1);

namespace Source\User\Application\Query;

use Source\Shared\CQRS\QueryBus\Query;

class CheckPasswordQuery implements Query
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
        return $this->password;
    }
}
