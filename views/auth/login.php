<?php

use App\Model\User;
use App\HTML\Form;
use App\Table\UserTable;

// Metadata
$title = "Connexion - Blogrem";
$description= "";
// ----------------------------------------- //

$user =  new User();

$errors = [];

if (!empty($_POST)){
    
    $user->set_username($_POST["username"]);
    
    if (!empty($_POST["username"]) && !empty($_POST["password"])){

        $table = new UserTable();

        // try{
        //     $usr = $table->find_by_username($_POST["username"]);
        // }
        // catch (Exception){
        //     // User not found
        //     $errors["password"] = "Identifiant ou mot de passe incorrect";
        // }

        $usr = $table->find_by_username($_POST["username"]);

        if ($usr !== null){
            if (password_verify($_POST["password"], $usr->get_password()) === true){
            
                session_start();
                $_SESSION["auth"] = password_hash($usr->get_id(), PASSWORD_BCRYPT);
    
                header("Location: " . $router->url("admin"));
                http_response_code(301);
                exit();
            }
            else{
                // Wrong password entered
                $errors["password"] = "Identifiant ou mot de passe incorrect";
            }
        }
        else{
            // User not found
            $errors["password"] = "Identifiant ou mot de passe incorrect";
        }
    }
    else{
        // No data entered
        $errors["password"] = "Identifiant ou mot de passe incorrect";
    }
}

?>

<h1>Se connecter</h1>
<hr class="border border-dark border-1">

<form action="" method="POST">
    <?php
        $form = new Form($user, $errors);
        echo $form->input("username", "Nom d'utilisateur");
        echo $form->input("password", "Mot de pass");
    ?>
    <button type="submit" class="btn btn-primary mt-4">Se connecter</button>
</form>