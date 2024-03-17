<?php

declare(strict_types=1);

namespace Source\User\Application\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Source\Shared\Application\Controller;
use Source\Shared\CQRS\CommandBus\CommandBus;
use Source\User\Application\Command\DeleteUserCommand;

class DeleteUserController implements Controller
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus) {
        $this->commandBus = $commandBus;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args
    ): ResponseInterface {
        try {
            $params = $request->getParams();
            $command = new DeleteUserCommand($params['user_id']);
            $this->commandBus->handle($command);
            return $response->withStatus(200);
        } catch (\Exception $e) {
            $code = $e->getCode() > 0 ? $e->getCode() : 503;
            return $response->withStatus($code, $e->getMessage());
        }
    }
}
