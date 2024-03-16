<?php

declare(strict_types=1);

namespace Source\User\Application\Command;

use Exception;
use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class CheckPasswordCommandHandler
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CheckPasswordCommand $command): bool
    {
        try{
            $user = $this->repository->findByEmail(new Email($command->getEmail()));
            return $user->getPassword()->toString() === $command->getPassword();
        } catch (Exception $e) {
            return false;
        }
    }
}
