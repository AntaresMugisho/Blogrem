<?php

// Metadata
$title = "Administration - Création d'article";
// ----------------------------------------- //

use App\HTML\Form;
use App\Helpers\ObjectHelper;
use App\Model\Category;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;

$table = new CategoryTable();
$category = new Category();

$errors = [];

if (!empty($_POST)){

    $v = new CategoryValidator($_POST, $table);
    
    $fields = ["name", "slug"];
    ObjectHelper::hydrate($category, $_POST, $fields);
   
    if($v->validate()) {
        $data = [];
        
        foreach ($fields as $field) {
            $getter = "get_" . $field;
            $data[$field] = $category->$getter();
        }

        $table->create($data);
        header("Location: " . $router->url("categories") . "?created=1");
        http_response_code(301);
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

        <h1>Créer une nouvelle catégorie</h1>
        <hr class="border border-dark border-1">

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">La catégorie n'a pas pu être créé !</div>
        <?php endif ?>

       <?php 
           $form = new Form($category, $errors);
           require "_form.php" 
        ?>