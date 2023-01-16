<?php

namespace App\core;

class Application
{
    public Router $router;
    public Request $request;
    public Database $database;
    public static string $ROOT_DIR;
    
    public function __construct($rootPath, $config)
    {
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->database = new Database('sqlite:' . $config::PATH_SQLITE_FILE);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}