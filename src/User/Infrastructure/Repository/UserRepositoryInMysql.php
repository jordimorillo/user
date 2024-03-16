<?php

declare(strict_types = 1);

namespace Source\User\Infrastructure\Repository;

use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\UserId;
use Source\User\Domain\ValueObject\UserRepositoryInterface;
use Source\User\Infrastructure\Repository\Exception\UserNotFoundException;

class UserRepositoryInMysql implements UserRepositoryInterface
{
    private \mysqli $mysqli;

    public function __construct(\mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function save(User $user): void
    {
        $stmt = $this->mysqli->prepare(
            "INSERT INTO users (user_id, email, password) VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE email = VALUES(email), password = VALUES(password)"
        );
        $userIdString = $user->getId()->toString();
        $emailString = $user->getEmail()->toString();
        $passwordString = $user->getPassword()->toString();
        $stmt->bind_param('sss', $userIdString, $emailString, $passwordString);
        $stmt->execute();
    }

    /**
     * @throws UserNotFoundException
     */
    public function findById(UserId $userId): User
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users WHERE user_id=?");
        $userIdString = $userId->toString();
        $stmt->bind_param('s', $userIdString);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row === null) {
            throw new UserNotFoundException();
        }
        return User::fromArray($row);
    }
}
