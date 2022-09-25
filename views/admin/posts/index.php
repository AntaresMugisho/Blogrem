<?php

// Metadata
$title = "Paneau d'administration";
// ----------------------------------------- //

use App\Table\PostTable;

[$posts, $paginated_query] = (new PostTable())->find_paginated_articles();

?>

<!--+------------------------------------------------------------+
    | Generating HTML code                                       |
    +------------------------------------------------------------+ -->

        <h1>Gestion d'articles</h1>
        <hr class="border border-dark border-1">

        <?php if (isset($_GET["deleted"])) : ?>
            <div class="alert alert-success">L'article a bien été supprimé ! </div>
        <?php endif ?>

        <?php if (isset($_GET["created"])) : ?>
            <div class="alert alert-success">L'article a bien été créé ! </div>
        <?php endif ?>

        <table class="table">
            <thead>
                <th>ID</th>
                <th>Titre</th>
                
                <th> <a href="<?= $router->url("create-post") ?>" class="btn btn-dark">Nouvel article</a> </th>

            </thead>
            <tbody>
                
                <?php foreach ($posts as $post):?>
                <tr>
                    <td># <?= $post->get_id() ?></td>
                    <td><?= $post->get_name() ?></td>
                    <td>
                        <a href="<?= $router->url("edit-post", ["id" => $post->get_id()]) ?>"  class="btn btn-primary me-4">Editer</a>
                        <form action="<?= $router->url("delete-post", ["id" => $post->get_id()]) ?>" method="POST"
                            onsubmit = "return confirm('Voulez vous vraiment supprimer cet article ?')" class="d-inline">
                            
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>

<?php $link = $router->url("posts")?>
<?= $paginated_query->previous_link($link); ?>
<?= $paginated_query->next_link($link); ?>