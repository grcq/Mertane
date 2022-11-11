<?php

namespace App\Command\Defaults;

use App\Command\Command;

class SetupDatabaseCommand extends Command {

    public function execute(array $args = []): void
    {
        $a = $this->ask("Test");
        $this->print($a . " - WORKS!");

        $b = $this->ask("Test 2", "ifskjgfds");
        $this->print($b . " - WORKS!");
    }

    public function getName(): string
    {
        return "db:setup";
    }

}