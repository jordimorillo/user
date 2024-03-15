<?php

declare(strict_types=1);

namespace Source\Shared;

class DependencyInjector
{
    public array $dependencies = [];

    private function addDependency(string $interface, $specification): void
    {
        $this->dependencies[$interface] = $specification;
    }

    public function addDependencies(array $dependencies): void
    {
        foreach($dependencies as $interface => $dependency) {
            $this->addDependency($interface, $dependency);
        }
    }

    public function get(): array
    {
        return $this->dependencies;
    }
}