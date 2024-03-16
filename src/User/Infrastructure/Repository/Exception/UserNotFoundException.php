<?php

declare(strict_types=1);

namespace Source\User\Infrastructure\Repository\Exception;

use Exception;

class UserNotFoundException extends Exception
{

    public function __construct()
    {
        parent::__construct('User not found', 404);
    }
}
