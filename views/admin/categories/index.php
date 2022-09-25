<?php

// Metadata
$title = "Admin - Gestion de catégories";
// ----------------------------------------- //

use App\Table\CategoryTable;


$categories = (new CategoryTable())->all();

?>

<!--+------------------------------------------------------------+
    | Generating HTML code                                       |
    +------------------------------------------------------------+ -->

        <h1>Gestion de catégories</h1>
        <hr class="border border-dark border-1">

        <?php if (isset($_GET["deleted"])) : ?>
            <div class="alert alert-success">La catégorie a bien été supprimé ! </div>
        <?php endif ?>

        <?php if (isset($_GET["created"])) : ?>
            <div class="alert alert-success">La catégorie a bien été créé ! </div>
        <?php endif ?>

        <table class="table">
            <thead>
                <th>ID</th>
                <th>Titre</th>
                <th>URL</th>
                
                <th> <a href="<?= $router->url("create-category") ?>" class="btn btn-dark">Nouvelle catégorie</a> </th>

            </thead>
            <tbody>
                
                <?php foreach ($categories as $category):?>
                <tr>
                    <td># <?= $category->get_id() ?></td>
                    <td> <?= $category->get_name() ?></td>
                    <td> <?= $category->get_slug() ?></td>
                    <td>
                        <a href="<?= $router->url("edit-category", ["id" => $category->get_id()]) ?>"  class="btn btn-primary me-4">Editer</a>
                        <form action="<?= $router->url("delete-category", ["id" => $category->get_id()]) ?>" method="POST"
                            onsubmit = "return confirm('Voulez vous vraiment supprimer cete catégorie ?')" class="d-inline">
                            
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>