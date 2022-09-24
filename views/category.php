<?php

// Metadata
$title = "Catégories";
$description = "";
// ----------------------------------------- //

use App\Table\CategoryTable;
use App\Table\PostTable;

// Get current category params
$id = (int)$params["id"];
$slug = $params["slug"];

// Get category
$category = (new CategoryTable())->find($id);
$link = $router->url("category", ["id" => $category->get_id(), "slug" => $category->get_slug()]);

// Redirect user if bad slug entered
if ($slug !== $category->get_slug()){
    $url = $router->url("category", ["slug" => $category->get_slug(), "id" => $category->get_id()]);
    http_response_code(301);
    header("Location: $url");
}

// List posts related to the current category
$post_table = new PostTable();
[$posts, $paginated_query] = $post_table->find_paginated_with_category($category->get_id());

?>

<!--+------------------------------------------------------------+
    | Generating HTML code                                       |
    +------------------------------------------------------------+ -->

        <h1 class="mb-4">Catégorie : <?= $category->get_name()?></h1>
        <hr class="border border-dark border-1">

        <div class="row">
            <?php foreach($posts as $post): ?>
            <div class="col-6 col-md-4 mb-4">
                <div class="card h-100" >
                    <div class="card-body ">
                        <h5 class="card-title"><?= $post->get_name() ?></h5>
                        <p class="text-muted fs-6 fst-italic"><?= $post->get_created_at()->format('d F Y') ?></p>
                        <p><?= $post->get_excerpt() ?></p>
                        <p><a href="<?= $router->url("article", ["slug" => $post->get_slug(), "id" => $post->get_id()])?>" class="btn btn-dark" >Voir plus</a></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

<?= $paginated_query->previous_link($link); ?>
<?= $paginated_query->next_link($link); ?>