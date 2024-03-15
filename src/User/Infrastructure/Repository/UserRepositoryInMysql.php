<?php

declare(strict_types = 1);

namespace Source\User\Infrastructure\Repository;

use Source\User\Domain\Entity\User;
use Source\User\Domain\ValueObject\UserRepositoryInterface;

class UserRepositoryInMysql implements UserRepositoryInterface {
    private \mysqli $mysqli;

    public function __construct(\mysqli $mysqli) {
        $this->mysqli = $mysqli;
    }

    public function save(User $user): void {
        $stmt = $this->mysqli->prepare(
            "INSERT INTO users (user_id, email, password) VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE email = VALUES(email), password = VALUES(password)"
        );
        $stmt->bind_param('sss', $userIdString, $emailString, $passwordString);
        $userIdString = $user->getId()->toString();
        $emailString = $user->getEmail()->toString();
        $passwordString = $user->getPassword()->toString();
        $stmt->execute();
    }
}