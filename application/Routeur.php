<?php
class Routeur 
/**
 * On vérifie l'existence des paramètres et de la configuration
 * On vérifie l'existence de données dans $_POST
 * 
 * @params :
 *  * url : array
 *  * config("defaultController","defaultAction") :array
 *  * $post (= $_POST) : array
 * 
 * @ouput : mixed
 */
{
    //Routing properties
    private string          $controller;
    private string           $action;
    private array|null      $parametres;
    private array|null      $data;

    //Config properties
    private string $defaultController;
    private string $defaultAction;

    //Constructor
    public function __construct(private array $url, private array $config, private array|null $post = null)
    {    
        if(array_key_exists("defaultController", $config) && array_key_exists("defaultAction", $config))
        {
            $this->defaultController    = $config["defaultController"];
            $this->defaultAction        = $config["defaultAction"];
        }
        else
        {
            throw new Exception("Erreur : la configuration n'est pas complète");
        }

        //Set $controller, $parametres
        if(isset($url[0]) && $url[0] != "")
        {
            $this->controller = "Controller".ucfirst($url[0]);
            if(isset($url[1]) && $url[1] != "")
            {
                $this->action = $url[1];
                if(isset($url[2]))
                {
                    unset($url[0]);
                    unset($url[1]);
                    $this->parametres = array_values($url);
                }
                else
                {
                    $this->parametres = null;
                }
            }
            else
            {
                $this->action       = $this->defaultAction;
                $this->parametres   = null;
            }
        }
        else
        {
            $this->controller   = "Controller".$this->defaultController;
            $this->action       = $this->defaultAction;
            $this->parametres   = null;
        }
        //We set $data
        if ($post != null)
        {
            $this->data = $post;
        }
        else
        {
            $this->data = null;
        }
    }

    //GETTERS
    public function getController() : string
    {
        return $this->controller;
    }
    public function getAction() : string
    {
        return $this->action;
    }
    public function getParameters() : array|null
    {
        return $this->parametres;
    }
    public function getData() : array|null
    {
        return $this->data;
    }
}