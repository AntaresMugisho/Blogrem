<?php

use App\Model\User;
use App\HTML\Form;
use App\Table\UserTable;

$user =  new User();

$errors = [];

if (!empty($_POST)){
    $user->set_username($_POST["username"]);

    if (empty($_POST["username"]) || empty($_POST["password"])){
        $errors["password"] = "Identifiant ou mot de passe incorrect";
    }
   
    $table = new UserTable;
    try{
        $u = $table->find_by_username($_POST["username"]);
        
        if (password_verify($_POST["password"], $u->get_password()) === false){
            $errors["password"] = "Identifiant ou mot de passe incorrect";
        }
        else{

            session_start();
            $_SESSION["auth"] = $u->get_id();
            //header("Location : " . $router->url("admin"));
            //http_response_code(301);
            exit();
        }
    }
    catch (Exception $e){  
        $errors["password"] = "Identifiant ou mot de passe incorrect" . $e;
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