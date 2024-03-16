<?php

declare(strict_types = 1);

namespace Source\Shared;

class DependencyInjector
{
    public array $dependencies = [];

    public function addDependencies(array $dependencies): void
    {
        foreach ($dependencies as $interface => $dependency) {
            $this->addDependency($interface, $dependency);
        }
    }

    private function addDependency(string $interface, $specification): void
    {
        $this->dependencies[$interface] = $specification;
    }

    public function get(): array
    {
        return $this->dependencies;
    }
}
