<?php

declare(strict_types = 1);

namespace Source\User\Infrastructure\Repository;

use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserId;
use Source\User\Domain\ValueObject\UserRepositoryInterface;
use Source\User\Infrastructure\Repository\Exception\UserNotFoundException;

use function PHPUnit\Framework\isEmpty;

class UserRepositoryInMemory implements UserRepositoryInterface
{
    private array $users;

    public function __construct(array $users = [])
    {
        $this->users = $users;
    }

    public function save(User $user): void
    {
        $this->users[$user->getId()->toString()] = $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function findById(UserId $userId): User
    {
        if (!isset($this->users[$userId->toString()])) {
            throw new UserNotFoundException();
        }
        return $this->users[$userId->toString()];
    }

    public function findByEmail(Email $email): User
    {
        $filteredArray = array_filter($this->users, static function (User $user) use ($email) {
            return $user->getEmail()->toString() === $email->toString();
        });
        return reset($filteredArray);
    }

    public function exists(Email $email, Password $password): bool
    {
        $filteredArray = array_filter($this->users, static function (User $user) use ($email, $password) {
            return $user->getEmail()->toString() === $email->toString()
                && $user->getPassword()->toString() === $password->toString();
        });
        return count($filteredArray) > 0;
    }
}
