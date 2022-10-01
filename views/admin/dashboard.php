<?php

use App\Auth;
use App\Security\ForbiddenException;

try{
    Auth::check();
}
catch (ForbiddenException){
    header("Location: " . $router->url("login"));
    http_response_code(301);
    exit();
}

// Metadata
$title = "Tableau de bord";
$description= "";
// ----------------------------------------- //

?>

<h1>Tableau de bord</h1>