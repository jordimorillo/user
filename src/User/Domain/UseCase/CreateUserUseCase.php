<?php

declare(strict_types=1);

namespace Source\User\Domain\UseCase;

use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class CreateUserUseCase
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password): void
    {
        $user = User::create(new Email($email), new Password($password));
        $this->userRepository->save($user);
    }
}