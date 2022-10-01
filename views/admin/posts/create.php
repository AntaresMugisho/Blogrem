<?php

// Metadata
$title = "Administration - Création d'article";
// ----------------------------------------- //

use App\Model\Post;
use App\Table\PostTable;
use App\HTML\Form;
use App\Helpers\ObjectHelper;

use App\Validators\PostValidator;

$table = new PostTable();
$post = new Post();

$errors = [];

if (!empty($_POST)){

    $v = new PostValidator($_POST, $table, $post->get_id());

    $fields = ["name", "slug", "content", "created_at"];
    ObjectHelper::hydrate($post, $_POST, $fields);
   
    if($v->validate()) {
        $data = [];
        
        foreach ($fields as $field) {
            $getter = "get_" . $field;
            $data[$field] = $post->$getter();
            if (is_object($data[$field])){
                $data[$field] = $data[$field]->format('Y-m-d H:i:s');
            }
        }

        $table->create($data);
        header("Location: " . $router->url("posts") . "?created=1");
        http_response_code(301);
        exit();
    }
    else {
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