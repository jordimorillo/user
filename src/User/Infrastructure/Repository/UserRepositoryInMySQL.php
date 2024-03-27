<?php

declare(strict_types = 1);

namespace Source\User\Infrastructure\Repository;

use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\Email;
use Source\User\Domain\ValueObject\Password;
use Source\User\Domain\ValueObject\UserId;
use Source\User\Domain\ValueObject\UserRepositoryInterface;
use Source\User\Infrastructure\Repository\Exception\UserNotFoundException;

class UserRepositoryInMySQL implements UserRepositoryInterface
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
        $stmt->close();
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
        $stmt->close();
        if($row === null) {
            throw new UserNotFoundException();
        }
        return User::fromArray($row);
    }

    /**
     * @throws UserNotFoundException
     */
    public function findByEmail(Email $email): User
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users where email=?");
        $emailString = $email->toString();
        $stmt->bind_param('s', $emailString);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        if($row === null) {
            throw new UserNotFoundException();
        }
        return User::fromArray($row);
    }

    public function exists(Email $email, Password $password): bool
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM users where email=? and password=?");
        $emailString = $email->toString();
        $passwordString = $password->toString();
        $stmt->bind_param('ss', $emailString, $passwordString);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        if($row === null) {
            return false;
        }
        return true;
    }

    public function delete(UserId $userId): void
    {
        $stmt = $this->mysqli->prepare("DELETE FROM users WHERE user_id=?");
        $userIdString = $userId->toString();
        $stmt->bind_param('s', $userIdString);
        $stmt->execute();
        $stmt->close();
    }
}
