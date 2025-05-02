<?php
//On génère une constante qui contient le chemin de index.php
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

//On charge les classes abstraites
require_once(ROOT.'application/Routeur.php');
require_once(ROOT.'application/Controller.php');
require_once(ROOT.'application/Model.php');


define('URL', $_GET['url']);

$configuration = array(
    'defaultController' => "Home",
    'defaultAction'     => "home"
);

$routing = new Routeur(
    explode('/', $_GET['url']),
    $configuration,
    $_POST
);

$controller = $routing->getController();
$action = $routing->getAction();

//We call the action associated with the controller with the rights parameters and data
if (file_exists(ROOT.'controllers/'.$controller.'.php'))
{
    require_once(ROOT.'controllers/'.$controller.'.php');

    $controller = new $controller();

    if(method_exists($controller, $action))
    {
        $controller->setConfig($configuration);

        $method = new ReflectionMethod($controller, $action);
        $numberOfRequiredParameters = $method->getNumberOfRequiredParameters();
        
        if ($numberOfRequiredParameters == 0)
        {
            $controller->$action();
        }
        elseif ($numberOfRequiredParameters == 1)
        {
            if($routing->getParameters() != null)
            {
                $controller->$action($routing->getParameters());
            }
            elseif($routing->getData() != null)
            {
                $controller->$action($routing->getData());
            }
            else
            {
                require_once(ROOT.'controllers/ControllerError.php');
    
                $controller = new ControllerError();
                $controller->error("Erreur : le nombre de paramètre(s) passé est incorrect");
                var_dump(URL);
            }
        }
        elseif ($numberOfRequiredParameters == 2)
        {
            $controller->$action($routing->getParameters(), $routing->getData());
        }
    }
    else
    {
        require_once(ROOT.'controllers/ControllerError.php');

        $controller = new ControllerError();
        $controller->error("Erreur : cette action n'existe pas");
        var_dump(URL);
    }
}
else
{
    require_once(ROOT.'controllers/ControllerError.php');

    $controller = new ControllerError();
    $controller->error("Erreur : ce controlleur n'existe pas");
    var_dump(URL);
}