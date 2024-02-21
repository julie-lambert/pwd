<?php
 
namespace App\Route;


class Router
{
    private $url;
    private $routes = [];

    public function __construct($url)
    {
        $this->url = $url;
    }


    public function get($path, $callback)
    {
        $route = new Route($path, $callback);
        $this->routes['GET'][] = $route;
    }


    public function post($path, $callback)
    {
        $route = new Route($path, $callback);
        $this->routes['POST'][] = $route;
    }

    public function run()
    {
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }

        }

        throw new RouterException('No routes matches');
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    








}
