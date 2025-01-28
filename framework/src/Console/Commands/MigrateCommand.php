<?php

namespace Learn\Custom\Console\Commands;

use Learn\Custom\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    protected string $name = 'migrate';

    public function execute(array $parameters = []): int
    {
        echo json_encode($parameters) . PHP_EOL;
        return 123123;
    }
}
