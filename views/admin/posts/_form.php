

<form action="" method="POST">
    <?= $form->input("name", "Titre");  ?>
    <?= $form->input("slug", "URL");  ?>
    <?= $form->textarea("content", "Contenu");  ?>
    <?= $form->input("created_at", "Date de création");  ?>
    
    <?php if ($post->get_id() === null) : ?>
        <button class="btn btn-primary mt-4">Créer l'article</button>
    <?php else :?>
        <button class="btn btn-primary mt-4">Modifier</button>
    <?php endif?>

</form>