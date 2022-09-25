<?php

// Metadata
$title = "Administration - Edition d'article";
// ----------------------------------------- //

use App\HTML\Form;
use App\Helpers\ObjectHelper;
use App\Table\CategoryTable;
use App\Validators\CategoryValidator;


$id = (int)$params["id"];

$table = new CategoryTable();
$category = $table->find($id);

$updated =  false;
$errors = [];

if (!empty($_POST)){

    $v = new CategoryValidator($_POST, $table, $category->get_id());
    
    $fields = ["name", "slug"];
    ObjectHelper::hydrate($category, $_POST, $fields);

    if($v->validate()) {

        $data = [];
        
        foreach ($fields as $field) {
            $getter = "get_" . $field;
            $data[$field] = $category->$getter();
        }

        $table->update($data, $category->get_id());
        $updated = true;
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

        <h1>Editer la catégorie</h1>
        <hr class="border border-dark border-1">

        <?php if ($updated): ?>
            <div class="alert alert-success">La catégorie a bien été modifiée.</div>

        <?php elseif (!empty($errors)): ?>
            <div class="alert alert-danger">La catégorie n'a pas pu être modifiée !</div>

        <?php endif ?>

        <?php 
           $form = new Form($category, $errors);
           require "_form.php" 
        ?>