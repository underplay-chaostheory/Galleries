<?php
abstract class Controller
{
    protected array|null $config;
    protected $model;

    public function setConfig(array $conf)
    {
        $this->config = $conf;
    }
    public function getConfig(): array|null
    {
        return $this->config;
    }

    protected function loadModel(string $mod)
    {
        require_once(ROOT . 'models/' . $mod . '.php');
        $this->model = new $mod();
    }

    protected function render(string $view_file, array $data = [])
    {
        extract($data);

        ob_start();

        if ($header != "default") {
            require_once(ROOT . 'views/resources/php/header/' . $header . '.php');
        }


        require_once(ROOT . 'views/' . str_replace("controller", "", strtolower(get_class($this)) . '/' . $view_file . '.php'));

        if ($footer != "default") {
            require_once(ROOT . 'views/resources/php/footer/' . $footer . '.php');
        }

        $content = ob_get_clean();

        require_once(ROOT . 'views/layouts/' . $template . '.php');
    }
}
