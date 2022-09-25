<?php

namespace App;

class Router {

    private $router;
    private $view_path;

    public function __construct(string $view_path)
    {
        $this->view_path = $view_path;

        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null): self
    {
        $this->router->map("GET", $url, $view, $name);
        return $this;
    }

    public function post(string $url, string $view, ?string $name = null): self
    {
        $this->router->map("POST", $url, $view, $name);
        return $this;
    }

    public function match(string $url, string $view, ?string $name = null): self
    {
        $this->router->map("GET|POST", $url, $view, $name);
        return $this;
    }

    public function url(string $name, array $params = []): ?string 
    {
        return $this->router->generate($name, $params);
    }

    public function run():self
    {
        $match = $this->router->match();
        $view = $match["target"] ?: "e404";

        $params = $match["params"];
        $router = $this;

        if ($view !== null){
            ob_start();

            require $this->view_path . $view . ".php";
            $main_content = ob_get_clean();
            
            $is_admin = strpos($view, "admin") !== false;
            $layout = $is_admin ? "admin/layout/default" : "layout/default";

            require $this->view_path . $layout . ".php";
        }

        return $this;
    }
}
?>

