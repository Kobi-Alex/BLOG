<?php
    require_once 'vendor/autoload.php';

    $controllerName = NULL;
    $actionName = NULL;
    $requestURI = preg_split('/\/|\?/', $_SERVER["REQUEST_URI"]);

    if (!isset($requestURI[1]) || $requestURI[1] == "") {
        $controllerName = 'blog';
    } else {
        $controllerName = $requestURI[1];
    }
    
    if (!isset($requestURI[2]) || $requestURI[2] == "") {
        $actionName = 'index';
    } else {
        $actionName = $requestURI[2];
    }
    
    $controllerPath = 'controllers/' . ucfirst($controllerName) . 'Controller.php';
    
    try {
        if (file_exists($controllerPath)) {
            $controllerClassName = '\\controllers\\' . ucfirst($controllerName) . 'Controller';
            // створення екземпляру класу
            $controller = new $controllerClassName;
            $methodName = 'action' . ucfirst($actionName);
            
            // var_dump($controllerClassName);
            // var_dump($methodName);

            if (method_exists($controller, $methodName)) {
                $controller->$methodName();
            } else {
                throw new Exception ("Method $methodName in controller class: $controllerClassName not found in $controllerPath");
            }
        } else {
            throw new Exception ("Controller file is not found: $controllerPath");
        }
        
    } catch (Exeption $e) {
        echo $e->getMessage();
    }