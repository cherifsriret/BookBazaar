<?php

/**
 * 
 */

 class Router 
 {

    protected $routes = [];

    public function define($routes) {
        $this->routes = $routes;
    }



    public static function load($file)
    {
        $router = new static;
        require 'app/'.$file;
        return $router;
    }


    public function direct($uri)
    {

        $uri = parse_url($uri)["path"];
        $prefix = App::get('config')['install_prefix'] ?? null;
        if (isset($prefix) && !empty($prefix))
        {
            if(strncmp($uri,$prefix,strlen($prefix)) == 0)
            {
                if(empty($uri = substr($uri,strlen($prefix) + 1)))
                {
                    $uri = "";
                }
            }
        }

   

        if(array_key_exists($uri, $this->routes))
        {
           
            if ($this->routes[$uri]['is_protected'] && empty($_SESSION['user'])) {
                // Redirect to login page
                Helper::redirect('login_form');
            }
            if ($this->routes[$uri]['is_protected']  && !in_array($_SESSION['user']['role'], $this->routes[$uri]['role'])) {
                // Redirect to 403 page forbidden
                Helper::redirect('403');
            }

            return $this->callAction(
                ...explode('@',$this->routes[$uri]['action'])
            );
        }
        else
        {
            Helper::redirect('404');
        }

        throw new Exception("No routes defined for this URI : ".$uri,1);
    }

    protected function callAction($controller,$action = 'index')
    {
        require_once("app/controllers/". $controller  . ".php");
        $control = new $controller;
        if(!method_exists($control, $action))
        {
            throw new Exception("$controller does not respond to the action $action.");
        }
        return $control->$action();   
    }


}
