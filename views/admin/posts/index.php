<?php

use App\Table\PostTable;

    $title = "Paneau d'administration";
    [$posts, $paginated_query] = (new PostTable())->find_paginated_articles();

?>

<!--+------------------------------------------------------------+
    | Generating HTML code                                       |
    +------------------------------------------------------------+ -->

        <h1>Paneau d'administration</h1>
        <hr class="border border-dark border-1">

        <?php if (isset($_GET["deleted"])) : ?>
            <div class="alert alert-success">L'article a bien été supprimé ! </div>
        <!--
            <div class="alert alert-danger">Echec de la suppression de l'article ! </div> -->
        <?php endif ?>

        <table class="table">
            <thead>
                <th>ID</th>
                <th>Titre</th>
                <th>Actions</th>

            </thead>
            <tbody>
                
                <?php foreach ($posts as $post):?>
                <tr>
                    <td># <?= $post->get_id() ?></td>
                    <td><?= $post->get_name() ?></td>
                    <td>
                        <a href="<?= $router->url("edition", ["id" => $post->get_id()]) ?>"  class="btn btn-primary me-4">Editer</a>
                        <form action="<?= $router->url("deletion", ["id" => $post->get_id()]) ?>" method="POST"
                            onsubmit = "return confirm('Voulez vous vraiment supprimer cet article ?')" class="d-inline">
                            
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>

<?php $link = $router->url("admin")?>
<?= $paginated_query->previous_link($link); ?>
<?= $paginated_query->next_link($link); ?>