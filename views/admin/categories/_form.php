

<form action="" method="POST">
    <?= $form->input("name", "Titre");  ?>
    <?= $form->input("slug", "URL");  ?>
    
    <?php if ($category->get_id() === null) : ?>
        <button class="btn btn-primary mt-4">Créer la catégorie</button>
    <?php else :?>
        <button class="btn btn-primary mt-4">Modifier</button>
    <?php endif?>

</form>