<?php

namespace Learn\Custom\Tests;

class LearnClass
{
    public function __construct(
        protected InjectedClass $injectedClass,
        protected InjectedSecondClass $injectedSecondClass,
    ) {}

    public function getInjectedClass(): InjectedClass
    {
        return $this->injectedClass;
    }
}
