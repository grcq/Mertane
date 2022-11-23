<?php

namespace App\Container\Cache;

enum FileType: string {

    case JSON = "json";
    case YAML = "yaml";

    public function toExt(): string
    {
        return match($this)
        {
            self::JSON => ".json",
            self::YAML => ".yaml",
            default => ".txt"
        };
    }

}