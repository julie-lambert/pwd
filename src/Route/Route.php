<?php

namespace App\Route;

class Route
{

    private $path;
    private $callback;
    private $matches;

    public function __construct($path, $callback)
    {
        $this->path = trim($path, '/');
        $this->callback = $callback;
    }

    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);

        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    public function call()
    {

        return call_user_func_array($this->callback, $this->matches);
    }
}
