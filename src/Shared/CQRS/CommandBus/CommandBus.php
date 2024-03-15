<?php

declare(strict_types=1);

namespace Source\Shared\CQRS\CommandBus;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

class CommandBus
{
    private Container $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function handle(Command $command)
    {
        $commandClass = get_class($command);
        $commandHandlerClass = $commandClass.'Handler';
        $commandHandler = $this->container->get($commandHandlerClass);
        $commandHandler->execute($command);
    }
}