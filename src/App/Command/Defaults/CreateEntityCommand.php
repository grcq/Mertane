<?php

namespace App\Command\Defaults;

use App\Command\Command;

class CreateEntityCommand extends Command {

    public function execute(array $args = []): void
    {
        $entityName = $this->ask("Name of entity");
        if (str_contains($entityName, " "))
        {
            $this->error("You cannot use space in entity name.");
            $this->execute($args);
            return;
        }

        $pageName = $this->ask("Page name for entity management", "none");

        $entityDirectory = \ROOT_PATH . "/src/App/Entity";
        if (!is_dir($entityDirectory))
        {
            mkdir($entityDirectory);
        }

        $filePath = $entityDirectory . "/" . $entityName . ".php";
        if (file_exists($filePath))
        {
            $this->error("Entity class already exists!");
            $this->execute($args);
            return;
        }

        $file = fopen($filePath, "w");
        $entityExampleFile = str_replace("{NAME}", $entityName, file_get_contents(\ROOT_PATH . "/entity.example"));

        fwrite($file, $entityExampleFile);
        fclose($file);

        if ($pageName == "none")
        {
            $this->success("Creating entity " . $entityName . " with no page management.");
            return;
        }

        $this->success("Creating entity " . $entityName . " with page management. Automatically set route to '/admin/" . strtolower($entityName) . "', you may change it.");
    }

    public function getName(): string
    {
        return "entity:create";
    }

}