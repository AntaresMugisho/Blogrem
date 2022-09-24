<?php

// Metadata
$title = "Administration - Edition d'article";
// ----------------------------------------- //

use App\Table\PostTable;
use App\Validator;
use App\HTML\Form;
use App\Helpers\ObjectHelper;

$id = (int)$params["id"];

$table = new PostTable();
$post = $table->find($id);

$updated =  false;
$errors = [];

if (!empty($_POST)){

    $v = new Validator($_POST);
    $v->labels(array(
        'name' => "Le titre",
        'slug' => "L'URL",
        'content' => "Le contenu"
    ));

    $v->rule("required", ["name", "slug"]);
    $v->rule("lengthBetween", ["name", "slug"], 3, 150);
    
    ObjectHelper::hydrate($post, $_POST, ["name", "slug", "content", "created_at"]);
   
    if($v->validate()) {
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

        <?php if (isset($_GET["created"])) : ?>
            <div class="alert alert-success">L'article a bien été créé ! </div>
        <?php endif ?>

        <?php if ($updated): ?>
            <div class="alert alert-success">L'article a été modifié.</div>

        <?php elseif (!empty($errors)): ?>
            <div class="alert alert-danger">L'article n'a pas pu être modifié !</div>

        <?php endif ?>

        <?php 
           $form = new Form($post, $errors);
           require "_form.php" 
        ?>