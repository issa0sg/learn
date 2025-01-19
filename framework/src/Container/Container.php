<?php

namespace Learn\Custom\Container;

use Learn\Custom\Container\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionParameter;

class Container implements ContainerInterface
{
    private array $services = [];

    public function get(string $id)
    {
        if (! $this->has($id)) {
            if (! class_exists($id)) {
                throw new ContainerException(sprintf('Service %s could not be resolve', $id));
            }

            $this->add($id);
        }

        return $this->resolve($this->services[$id]);
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    public function add(string $id, $concrete = null)
    {
        if (is_null($concrete)) {
            if (! class_exists($id)) {
                throw new ContainerException(sprintf('Service %s does not exist', $id));
            }
            $concrete = $id;
        }

        $this->services[$id] = $concrete;
    }

    private function resolve($class)
    {
        $reflectClass = new ReflectionClass($class);

        $reflectConstructor = $reflectClass->getConstructor();

        if (! $reflectConstructor) {
            return $reflectClass->newInstance();
        }

        $constructorParams = $reflectConstructor->getParameters();

        $dependencies = $this->resolveClassDependencies($constructorParams);

        return $reflectClass->newInstanceArgs($dependencies);
    }

    private function resolveClassDependencies($constructorParams): array
    {
        $resolvedDependencies = [];
        /** @var ReflectionParameter $constructorParam */
        foreach ($constructorParams as $constructorParam) {

            $classType = $constructorParam->getType();

            $resolvedClass = $this->get($classType->getName());

            $resolvedDependencies[] = $resolvedClass;
        }

        return $resolvedDependencies;
    }
}
