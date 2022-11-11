<?php

namespace App\Command;

use App\Container\Container;

abstract class Command {

    public abstract function execute(array $args = []): void;

    public abstract function getName(): string;

    public Container $container;

    public function __construct()
    {
        $this->container = Container::init();
    }

    public final function success(string $message): void
    {
        $this->printC("[SUCCESS] " . $message, "s");
    }

    public final function error(string $message): void
    {
        $this->printC("[ERROR] " . $message, "e");
    }

    public final function info(string $message): void
    {
        $this->printC("[INFO] " . $message, "i");
    }

    public final function warning(string $message): void
    {
        $this->printC("[WARNING] " . $message, "w");
    }

    public final function print(string $message): void
    {
        $this->printC($message);
    }

    public final function ask(string $question, string $defaultValue = "", bool $emptyResponse = false): string
    {
        $response = $this->readline("\033[32m" . $question . ($defaultValue == "" ? "" : " \033[0m[\033[33m" . $defaultValue . "\033[0m]") . "\033[32m:\033[0m\n");
        if ($response == "" && $defaultValue == "" && !$emptyResponse)
        {
            $this->error("You must fill out this question!");
            return $this->ask($question, $defaultValue, $emptyResponse);
        }

         if ($response == "") return $defaultValue;

        return $response;
    }

    private function readline(string $str): string
    {
        print_r("$str");
        $response = trim(fgets(STDIN, 1024));
        return $response;
    }

    private function printC($str, $type = ''){
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
                print_r($str . "\n");
                break;
        }
    }

}