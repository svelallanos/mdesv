<?php

require_once("Controllers/Error.php");
$controller = strtolower($controller);

$arrayDir = scandir(PATH_CONTROLLERS);

foreach ($arrayDir as $key => $value) {
    if (strtolower($value) == $controller . '.php') {
        $controller = $value;
        $class = explode('.php', $value);
        $class = $class[0];
    }

    $controllerFile = PATH_CONTROLLERS . $controller;
}

if (file_exists($controllerFile)) {
    require_once($controllerFile);

    $controller = new $class();

    if (method_exists($controller, $methop)) {
        if ($params === '') {
            $params = array();
        } else {
            $params = explode(',', $params);
        }

        try {
            call_user_func_array(array($controller, $methop), $params);
        } catch (TypeError $e) {
            if (
                isset($e->getTrace()[0]) && isset($e->getTrace()[0]['function']) &&
                isset($e->getTrace()[0]['class']) && isset($e->getTrace()[0]['file']) &&
                strtolower(quitarTildes($methop)) != strtolower(quitarTildes($e->getTrace()[0]['function'])) 
                // && ENV_PRODUCCION === false
            ) {
                $mensaje = '<b>ERROR:</b> ' . $e->getMessage();
                $trace = $e->getTrace();
                $mensaje = str_replace($trace[0]['class'], 'Controller', $mensaje);
                $mensaje = str_replace($trace[0]['function'], 'Method', $mensaje);
                $mensaje = str_replace($trace[0]['file'], 'File', $mensaje);
                $mensaje = str_replace('on line', '<b>ON LINE => </b>', $mensaje);

                echo $mensaje;
                die;
            }
            json('Error');

            $notFound = new Errors();
            $notFound->notFound();
        } catch (ArgumentCountError $e) {
            $notFound = new Errors();
            $notFound->notFound();
        }
    } else {
        $notFound = new Errors();
        $notFound->notFound();
    }
} else {
    $notFound = new Errors();
    $notFound->notFound();
}
