<?php

namespace App\Command;

class CommandHandler {

    private $argc;
    private $argv;

    private array $commands = [];

    private function print($str, $type = ''){
        switch ($type) {
            case 'e':
                print_r("\033[41;30m$str\033[0m\n");
                break;
            case 's':
                print_r("\033[42;30m$str\033[0m\n");
                break;
            case 'w':
                print_r("\033[44;30m$str\033[0m\n");
                break;  
            case 'i':
                print_r("\033[46;30m$str\033[0m\n");
                break;      
            default:
                print_r($str);
                break;
        }
    }
    
    public function __construct($argc, $argv)
    {
        $this->argc = $argc;
        $this->argv = $argv;
    }

    public function register(Command $command) 
    {
        $name = $command->getName();
        $this->commands += ["$name" => $command];
    }

    public function run()
    {
        if (count($this->argv) < 2) 
        {
            print_r("Please type \"php admin --help\" for more information.\n");
            return;
        }

        switch ($this->argv[1]) 
        {
            case "--help":
                $i = 0;
                print_r("Commands:\n");
                foreach ($this->commands as $var => $val)
                {
                    $i++;
                    print_r($i . " - " . $var . "\n");
                }
                break;
            default:
                if (!isset($this->commands[$this->argv[1]])) 
                {
                    $this->print("Error: No command with name '" . $this->argv[1] . "' is registered.", "e");
                    break;
                }

                $command = $this->commands[$this->argv[1]];
                $command->execute($this->argv);
        }
    }

}