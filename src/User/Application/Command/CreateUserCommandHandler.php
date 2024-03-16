<?php

declare(strict_types = 1);

namespace Source\User\Application\Command;

use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class CreateUserCommandHandler
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(CreateUserCommand $command): void
    {
        $user = User::create(new Email($command->getEmail()), new Password($command->getPassword()));
        $this->userRepository->save($user);
    }
}
