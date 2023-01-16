<?php

namespace App\core;

use App\core\Permission;  

class Router
{    
    public array $routes = [];
    public Request $request;


    public function __construct($request)
    {
        $this->request = $request;
    }


    // init les routes
    public function get($path, $callback, $layout = false)
    {
        $this->routes['get'][$path] = [$callback, $layout];
    }


    public function post($path, $callback)
    {
        $this->routes['post'][$path] = [$callback];
    }

    // décide d'une action en fonction du path
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path][0] ?? false;
        $layout = $this->routes[$method][$path][1] ?? false;

        if(!$callback) return $this->renderView('error');
        
        if(is_string($callback)) return $this->renderView($callback, $layout);
        
        return call_user_func($callback);
    }


    public function renderView($view, $layout = false, $params = false)
    {
        if(Permission::hasPermission('view', $view)){

            $viewContent = $this->getView($view, $params);

            if($layout){
                $layoutContent = $this->getLayout($layout);
                return str_replace('{{content}}', $viewContent, $layoutContent);
            } 
                
            $head = $this->getHead();

            return $head . $viewContent;
        }

        header('location:/login');
    }


    protected function getView($view, $params)
    {
        if($params){
            foreach($params as $key => $value) {
                $$key = $value;
            }
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    
    protected function getLayout($layout)
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }


    protected function getHead()
    {
        ob_start();
        include_once Application::$ROOT_DIR . "/views/components/header.php";
        return ob_get_clean();
    }
}