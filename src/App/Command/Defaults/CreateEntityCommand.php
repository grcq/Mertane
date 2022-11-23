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

        $fields = [];
        $newField = $this->ask("Do you want to create a field for this entity?", "y");
        if ($newField == "y")
        {
            $fields = $this->newField($fields);
        }

        $temp = [];
        $gettersAndSetters = [];
        foreach ($fields as $name => $value)
        {
            array_push($temp, "private " . $value . " $" . $name . ";");
            array_push($gettersAndSetters, "public function " . ($value == "bool" || $value == "boolean" ? "is" : "get") . ucfirst($name) . "(): " . $value . "\n    {\n        return $" . "this->" . $name . ";\n    }");
            array_push($gettersAndSetters, "public function set" . ucfirst($name) . "(" . $value . " $" . $name . "): void\n    {\n        $" . "this->" . $name . " = $" . $name . ";\n    }");
        }

        $fields = $temp;

        $file = fopen($filePath, "w");
        $entityExampleFile = str_replace("{NAME}", $entityName, file_get_contents(\ROOT_PATH . "/entity.example"));
        $entityExampleFile = str_replace("{FIELDS}", (empty($fields) ? "" : implode("\n\n    ", $fields)), $entityExampleFile);
        $entityExampleFile = str_replace("{GETTERSANDSETTERS}", (empty($gettersAndSetters) ? "" : implode("\n\n    ", $gettersAndSetters)), $entityExampleFile);

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

    private function newField(array $currentFields): array
    {
        $fieldName = $this->ask("Name of the field");
        $fieldType = $this->ask("Type of the field", "string");

        $currentFields += ["{$fieldName}" => $fieldType];

        $anotherField = $this->ask("Do you want to add another field?", "y");
        if ($anotherField == "y")
        {
            return $this->newField($currentFields);
        }

        return $currentFields;
    }

}