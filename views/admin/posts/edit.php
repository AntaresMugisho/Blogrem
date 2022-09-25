<?php

// Metadata
$title = "Administration - Edition d'article";
// ----------------------------------------- //

use App\Table\PostTable;
use App\HTML\Form;
use App\Helpers\ObjectHelper;
use App\Validators\PostValidator;

$id = (int)$params["id"];

$table = new PostTable();
$post = $table->find($id);

$updated =  false;
$errors = [];

if (!empty($_POST)){

    $v = new PostValidator($_POST, $table, $post->get_id());
    
    $fields = ["name", "slug", "content", "created_at"];
    ObjectHelper::hydrate($category, $_POST, $fields);
    
    if($v->validate()) {

        $data = [];
        
        foreach ($fields as $field) {
            $getter = "get_" . $field;
            $data[$field] = $post->$getter();
        }

        $table->update($data, $post->get_id());
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

        <?php elseif (!empty($errors)): ?>
            <div class="alert alert-danger">L'article n'a pas pu être modifié !</div>

        <?php endif ?>

        <?php 
           $form = new Form($post, $errors);
           require "_form.php" 
        ?>