<?php $title = 'Billets';
// Permet de mémoriser le code html qui suit en le mettant dans la variable "content"
ob_start(); 
if (!empty($_SESSION['user'])) {
?>
<!-- Ajout d'un chapitre si administrateur connecté-->
<h2 class="py-4">Ajout d'un billet</h2>

<div class="news">
    <form action="index.php?action=addPost" method="post">
        <div class="form-group">
            <label for="title">Titre</label>
            <input class="form-control my-2" type="text" id="title" name="title" />
            <div class="form-group my-2">
                <label for="content">Contenu</label>
                <textarea class="form-control" id="content" name="content"></textarea>
            </div>
            <button type="submit" class="btn btn-primary my-3" name="newPost" value="Ajouter">Ajouter</button>
        </div>
    </form>
</div>

<?php
}
?>

<?php $this->pagination($nbPost); ?>
<!-- On est ici à l'intérieur de la méthode displayView qui affiche la vue. On est donc au sein de la classe MainController, on peut donc utiliser des méthodes de cette classe -->

<h2 class="py-4">Billets en ligne</h2>
<!-- Chapitres : affiche chaque entrée une à une (avec sécurité pour les failles XSS) -->
<?php
while ($data = $posts->fetch()) {
?>

    <div class="news">
        <h3 class="py-3">
            <?php echo htmlspecialchars($data['chapter_title']); ?>
        </h3>
        <p class="font-italic">publié le
            <?php echo htmlspecialchars($data['chapter_date_fr']); ?>
        </p>

        <!-- Edit or delete chapters if admin-->
        <?php
if (!empty($_SESSION['user'])) {
?>
            <a href="index.php?action=editPostForm&amp;chapter_id=<?php echo htmlspecialchars($data['chapter_id']); ?>"><i class="fas fa-pencil-alt pr-3" title="Modifier" aria-hidden="true"></i></a>

            <a href="index.php?action=deletePost&amp;chapter_id=<?php echo htmlspecialchars($data['chapter_id']); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce billet ?'));"><i class="fas fa-trash" title="Supprimer" aria-hidden="true"></i></a>
            <?php
}
?>
            <p class="mt-3">
                <?php echo $this->getExcerpt($data['chapter_content']); ?>
            </p>
            <!-- On utilise ici un $this car on est toujours dans la méthode displayAllPost du frontendController -->
            <a href="index.php?action=displayOnePost&amp;chapter_id=<?php echo htmlspecialchars($data['chapter_id']); ?>">Lire la suite...</a>
    </div>
    <?php
}
// Termine le traitement de la requête
$posts->closeCursor(); 
$content = ob_get_clean(); ?>
