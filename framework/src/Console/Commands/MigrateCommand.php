<?php

namespace Learn\Custom\Console\Commands;

use Learn\Custom\Console\CommandInterface;

class MigrateCommand implements CommandInterface
{
    protected string $name;

    public function execute(array $parameters = []): int
    {

        return 0;
    }

}
