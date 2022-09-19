<?php

use App\Table\PostTable;
use Valitron\Validator;
use App\HTML\Form;


$title = "Administration - Edition d'article";

$id = (int)$params["id"];

$table = new PostTable();
$post = $table->find($id);

$updated =  false;
$errors = [];

if (!empty($_POST)){

    Validator::lang("fr");
    $v = new Validator($_POST);

    $v->labels(array(
        'name' => "Le titre",
        'slug' => "L'URL",
        'content' => "Le contenu"
    ));

    $v->rule("required", ["name", "slug"]);
    $v->rule("lengthBetween", ["name", "slug"], 3, 150);
 

    if($v->validate()) {
        $post
            ->set_name($_POST["name"])
            ->set_slug($_POST["slug"])
            ->set_content($_POST["content"])
            ->set_created_at($_POST["created_at"]);

        $table->update($post);
        $updated = true;
    } else {
        // Errors
        $errors = $v->errors();
    }
}

?>

<!--+------------------------------------------------------------+
    | Generating HTML code                                       |
    +------------------------------------------------------------+ -->

        <h1>Editer un article</h1>
        <hr class="border border-dark border-1">

        <?php if ($updated): ?>
            <div class="alert alert-success">L'article a été modifié.</div>
        <?php endif ?>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">L'article n'a pas pu être modifié !</div>
        <?php endif ?>

        <form action="" method="POST">
            <?php $form = new Form($post, $errors);?>
            <?= $form->input("name", "Titre");  ?>
            <?= $form->input("slug", "URL");  ?>
            <?= $form->textarea("content", "Contenu");  ?>
            <?= $form->input("created_at", "Date de création");  ?>
            
            <button class="btn btn-primary mt-4">Enregistrer les modifications</button>
        </form>