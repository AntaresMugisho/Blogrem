<?php

// Metadata
$title = "Administration - Création d'article";
// ----------------------------------------- //

use App\Model\Post;
use App\Table\PostTable;
use App\Validator;
use App\HTML\Form;
use App\Helpers\ObjectHelper;

$table = new PostTable();
$post = new Post();

$errors = [];

if (!empty($_POST)){

    $v = new Validator($_POST);
    $v->labels(array(
        'name' => "Le titre",
        'slug' => "L'URL",
        'content' => "Le contenu"
    ));

    $v->rule("required", ["name", "slug", "content"]);
    $v->rule("lengthBetween", ["name", "slug"], 3, 150);
    //$v->rule("lengthMoreThan", "content", 255);
    
    ObjectHelper::hydrate($post, $_POST, ["name", "slug", "content", "created_at"]);
   
    if($v->validate()) {
        $table->create($post);
        header("Location: " . $router->url("edition", ["id"=>$post->get_id()]) . "?created=1");
    }else {
        // Errors
        $errors = $v->errors();
    }
}

?>

<!--+------------------------------------------------------------+
    | Generating HTML code                                       |
    +------------------------------------------------------------+ -->

        <h1>Créer un nouvel article</h1>
        <hr class="border border-dark border-1">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">L'article n'a pas pu être créé !</div>
        <?php endif ?>

       <?php 
           $form = new Form($post, $errors);
           require "_form.php" 
        ?>