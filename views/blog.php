<?php 

$title = "Articles";
$description = "";

use App\Table\PostTable;

$post_table = new PostTable();
[$posts, $paginated_query] = $post_table->find_paginated_articles();


$link = $router->url("blog");

?>

<!--+------------------------------------------------------------+
    | Generating HTML code                                       |
    +------------------------------------------------------------+ -->

        <h1 class="mb-4">Mon blog </h1>
        <hr class="border border-dark border-1">

        <div class="row">
            <?php foreach($posts as $post): ?>
            <div class="col-6 col-md-4 mb-4">
                <div class="card h-100" >
                    <div class="card-body ">
                        <h5 class="card-title"><?= $post->get_name() ?></h5>
                        <p class="text-muted fs-6 fst-italic"><?= $post->get_created_at()->format('d F Y') ?></p>
                        
                        <?php foreach ($post->get_categories() as $category) :
                            $link = $router->url("category", ["slug"=>$category->get_slug(), "id" => $category->get_id()]) ?>
                            <a href="<?= $link ?>" class="text fs-6 text-decoration-none"><?= $category->get_name()?></a>
                        <?php endforeach; ?>
                    
                        <p><?= $post->get_excerpt() ?></p>
                        <p><a href="<?= $router->url("article", ["slug" => $post->get_slug(), "id" => $post->get_id()])?>" class="btn btn-dark" >Voir plus</a></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

<?= $paginated_query->previous_link($link); ?>
<?= $paginated_query->next_link($link); ?>