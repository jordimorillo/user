<?php

declare(strict_types=1);

// User Routes
global $app;

use Source\User\Application\Controller\ChangePasswordController;
use Source\User\Application\Controller\CreateAUserController;
use Source\User\Application\Controller\DeleteUserController;

// Add the routes here like in the following example:
$app->post('/user', CreateAUserController::class);
$app->put('/user', ChangePasswordController::class);
$app->delete('/user', DeleteUserController::class);
