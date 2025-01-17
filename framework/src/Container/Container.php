<?php

namespace Learn\Custom\Container;

use Learn\Custom\Container\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $services = [];

    public function get(string $id)
    {
        return new $this->services[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->services[$id]);
    }

    public function add(string $id, $concrete = null)
    {
        if (is_null($concrete)) {
            if (!class_exists($id)) {
                throw new ContainerException(sprintf("Service %s does not exist", $id));
            }
            $concrete = $id;
        }

        $this->services[$id] = $concrete;
    }
}