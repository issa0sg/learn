<?php

namespace Learn\Custom\Console;

interface CommandInterface
{
    public function execute(array $parameters = []): int;
}