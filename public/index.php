<?php

require "../vendor/autoload.php";

define("DEBUG_TIME", microtime(true));

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

$VIEW_PATH = dirname(__DIR__) . "/views/";

$router = new App\Router($VIEW_PATH);

$router
    ->get("/", "home", "home")
    ->get("/category/[*:slug]-[i:id]", "category", "category")  
    ->get("/blog/[*:slug]-[i:id]", "article", "article")
    ->get("/blog", "blog", "blog")

    ->get("/admin/manage-posts", "admin/posts/index", "posts")
    ->match("/admin/post/edit/[i:id]", "admin/posts/edit", "edit-post")
    ->post("/admin/post/delete/[i:id]", "admin/posts/delete", "delete-post")
    ->match("/admin/post/create", "admin/posts/create", "create-post")
    ->get("/admin", "admin/dashboard", "admin")
    ->run();    
    
?>