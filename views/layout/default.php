<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? "Mon site" ?></title>
    <meta name="description" content="<?= $description ?? "" ?> ">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= $router->url("home") ?>">Blogrem</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link" href="<?= $router->url("blog") ?>">Articles</a>
                    </li>
                </ul>
                </div>
            </div>
        </nav>
        
    </header>

    <main class="container mt-4">
        <?= $main_content; ?>

    </main>

    <footer class="bg-light py-4 px-4 mt-4">

     <div>
        <?php if (defined('DEBUG_TIME')): ?>
            Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME))?> ms
         <?php endif?>
    </div> 

    </footer>
    
    <?= $script ?? "" ?>

</body>
</html>
   