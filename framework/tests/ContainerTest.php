<?php

namespace Learn\Custom\Tests;

use Learn\Custom\Container\Container;
use Learn\Custom\Container\Exceptions\ContainerException;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function test_getting_service_from_container()
    {
        $container = new Container;

        $container->add('somecode-class', LearnClass::class);

        $this->assertInstanceOf(LearnClass::class, $container->get('somecode-class'));
    }

    public function test_container_exception_add_wrong_service()
    {
        $container = new Container;

        $this->expectException(ContainerException::class);

        $container->add('somecode-class');
    }

    public function test_container_has_service()
    {
        $container = new Container;

        $container->add('somecode-class', LearnClass::class);

        $this->assertTrue($container->has('somecode-class'));
    }

    public function test_container_has_not_service()
    {
        $container = new Container;

        $this->assertFalse($container->has('somecode-class'));
    }

    public function test_recursively_autowired()
    {
        $container = new Container;

        $container->add('learn-class', LearnClass::class);

        /** @var LearnClass $learnClass */
        $learnClass = $container->get('learn-class');

        $this->assertInstanceOf(InjectedClass::class, $learnClass->getInjectedClass());
    }
}
