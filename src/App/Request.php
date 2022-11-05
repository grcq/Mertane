<?php

namespace App;

class Request {

    private string $uri;
    private ?\Smarty $smarty;
    private ?object $class;
    private ?array $get;
    private ?array $post;

    public function __construct(string $uri, ?\Smarty $smarty, ?object $class = null, ?array $get = null, ?array $post = null)
    {
        $this->uri = $uri;
        $this->smarty = $smarty;
        $this->class = $class;
        $this->get = $get;
        $this->post = $post;
    }

    public function getURI(): string
    {
        return $this->uri;
    }

    public function getClass(): ?object
    {
        return $this->class;
    }

    public function getRequest(string $type): ?array
    {
        switch ($type)
        {
            case "GET":
                return $this->get;
            case "POST":
                return $this->post;
        }

        return null;
    }

    public function getSmarty(): ?\Smarty
    {
        return $this->smarty;
    }

}