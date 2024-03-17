<?php

declare(strict_types = 1);

namespace Source\Shared\CQRS\QueryBus;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;

class
QueryBus
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function handle(Query $query)
    {
        $queryClass = get_class($query);
        return $this->container->get($queryClass . 'Handler')->handle($query);
    }
}
