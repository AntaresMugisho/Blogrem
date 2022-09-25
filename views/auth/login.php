<?php

use App\Model\User;
use App\HTML\Form;

$user =  new User();

if (!empty($_POST)){
    if (empty($_POST["username"]) || empty($_POST["password"]) ){
        $errors["password"] = "Identifiant ou mot de passe incorrect";
    }
}


?>


<h1>Se connecter</h1>
<hr class="border border-dark border-1">

<form action="" method="POST">
    <?php
        $form = new Form($user, []);
        echo $form->input("username", "Nom d'utilisateur");
        echo $form->input("password", "Mot de pass");
    ?>
    <button type="submit" class="btn btn-primary mt-4">Se connecter</button>
</form>