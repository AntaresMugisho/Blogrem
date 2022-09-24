<?php

use App\Table\PostTable;
use App\Table\CategoryTable;

$id = (int)$params["id"];
$slug = $params["slug"];

$post = (new PostTable())->find($id);
(new CategoryTable())->find_related_categories([$post]);

// Redirect user if bad slug entered
if ($slug !== $post->get_slug()){
    $url = $router->url("article", ["slug" => $post->get_slug(), "id" => $post->get_id()]);
    http_response_code(301);
    header("Location: $url");
}
?>

<!--+------------------------------------------------------------+
    | Generating HTML code                                       |
    +------------------------------------------------------------+ -->
        <?php
            // Metadata
            $title = $post->get_name();
            $description = $post->get_excerpt();
            // ----------------------------------------- //
        ?>

        <h1 class="mb-4"> <?= $post->get_name() ?> </h1>

        <?php 
        foreach ($post->get_categories() as $category):
            $link = $router->url("category", ["slug" => $category->get_slug(), "id" =>  $category->get_id()]);?>
            <a href="<?= $link ?>" class="text-decoration-none d-inline-block fs-6 rounded px-2 py-1 m-1 text-dark bg-primary bg-opacity-25"><?= $category->get_name() ?></a>

        <?php endforeach ?>

        <hr class="border border-dark border-1">
        <p class="mt-4"><?= $post->get_content() ?></p>