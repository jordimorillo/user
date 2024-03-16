<?php

declare(strict_types=1);

namespace Source\User\Application\Command;

use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class ChangePasswordCommandHandler
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(ChangePasswordCommand $command): void
    {
        $user = $this->userRepository->findByEmail(new Email($command->getEmail()));
        $user->changePassword(new Password($command->getPassword()));
        $this->userRepository->save($user);
    }
}
