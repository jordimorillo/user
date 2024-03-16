<?php

declare(strict_types = 1);

namespace Source\User\Domain\Entity;

use mysqli_result;
use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserId;

class User
{

    private UserId $userId;
    private Email $email;
    private Password $password;

    private function __construct(UserId $userId, Email $email, Password $password)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->password = $password;
    }

    public static function create(Email $email, Password $password): self {
        return new self(
            new UserId(),
            $email,
            $password
        );
    }

    public static function fromArray(array $result): self
    {
        return new self(
            new UserId($result['user_id']),
            new Email($result['email']),
            new Password($result['password'])
        );
    }

    public function getId(): UserId
    {
        return $this->userId;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }
}
