<?php

namespace Learn\Custom\Console;

class Kernel
{

    public function handle(): int {
        $this->registerCommands();
        return 0;
    }


    private function registerCommands(): void
    {
        $commandFiles = new \DirectoryIterator(__DIR__.'/Commands');

        foreach ($commandFiles as $commandFile) {
            if (!$commandFile->isFile()) {
                continue;
            }


        }
    }
}