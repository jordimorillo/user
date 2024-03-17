<?php

declare(strict_types=1);

namespace Source\User\Application\Controller;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Shared\Application\Controller;
use Source\Shared\CQRS\CommandBus\CommandBus;
use Source\User\Application\Command\CreateUserCommand;

class CreateAUserController implements Controller
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $parameters = json_decode($request->getBody()->getContents(), true);
            $command = new CreateUserCommand($parameters['email'], $parameters['password']);
            $this->commandBus->handle($command);
            return $response->withStatus(200);
        } catch (Exception $e) {
            return $response->withStatus($e->getCode(), $e->getMessage());
        }
    }
}
