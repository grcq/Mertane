<?php

namespace App\Container;

use App\Container\Cache\FileType;
use App\Container\Container;

class CacheContainer extends Container {

    private ?string $id = null;
    private FileType $fileType = FileType::JSON;
    private string $path = ROOT_PATH . "/cache";
    private string $cache = "default";

    public function __construct()
    {
        if (!isset($_COOKIE['sessid']))
        {
            $this->id = bin2hex(random_bytes(8));
            setcookie("sessid", $this->id, (time() + (86400 * 30)));
        } else $this->id = $_COOKIE['sessid'];

        if (!is_dir($this->path)) mkdir($this->path);

        $file = $this->path . "/" . $this->id . $this->fileType->toExt();
        if (!file_exists($file))
        {
            $f = fopen($file, "w");
            switch ($this->fileType)
            {
                case FileType::JSON:
                    fwrite($f, "{}");
                    break;
                default:
                    break;
            }

            fclose($f);
        }
    }

    public function setCache(string $c): void
    {
        $this->cache = $c;
    }

    public function getFileType(): FileType
    {
        return $this->fileType;
    }

    public function setFileType(FileType $type): void
    {
        $this->fileType = $type;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function put(string $path, $value): void
    {
        $file = $this->path . "/" . $this->id . $this->fileType->toExt();
        switch ($this->fileType)
        {
            case FileType::JSON:
                $c = json_decode(file_get_contents($file), true);
                if (!isset($c[$this->cache])) $c[$this->cache] = array();
                if (!isset($c[$this->cache][$path])) 
                {
                    $c[$this->cache][$path] = $value;
                }

                file_put_contents($file, json_encode($c, JSON_PRETTY_PRINT));
                break;
            case FileType::YAML:
                break;
            default:
                break;
        }
    }

    public function fetch(string $path, $defaultReturn = null): mixed
    {
        $output = $defaultReturn;
        $file = $this->path . "/" . $this->id . $this->fileType->toExt();
        switch ($this->fileType)
        {
            case FileType::JSON:
                $c = json_decode(file_get_contents($file), true);
                if (!isset($c[$this->cache])) $c[$this->cache] = array();
                if (isset($c[$this->cache][$path])) $output = $c[$this->cache][$path];

                break;
            case FileType::YAML:
                break;
            default:
                break;
        }

        return $output;
    }

}