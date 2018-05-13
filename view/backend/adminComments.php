<?php $title = 'Commentaires signalés';
ob_start(); ?>

<!-- Affichage des commentaires signalés -->
<h2 class="py-4">Commentaires signalés</h2>

<?php
// fetch permet de récupérer le résultat d'une requête
while ($comment = $comments->fetch()) { 
?>
    <div>
        <strong><?php echo htmlspecialchars($comment['comment_author']); ?></strong>
        <i>le <?php echo htmlspecialchars($comment['comment_date_fr']); ?></i>

        <span><a href="index.php?action=editCommentForm&amp;comment_id=<?php echo htmlspecialchars($comment['comment_id']); ?>"><i class="fas fa-pencil-alt px-3" aria-hidden="true" title="Modifier"></i></a></span>



        <a href="index.php?action=deleteComment&amp;comment_id=<?php echo htmlspecialchars($comment['comment_id']); ?>&amp;id_chapt=<?php echo htmlspecialchars($comment['id_chapt']); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce commentaire ?'));"><i class="fas fa-trash" aria-hidden="true" title="Supprimer"></i></a>

        <p class="mt-3">
            <?php echo htmlspecialchars($comment['comment_content']); ?>
        </p>
    </div>

    <div>
        <p>En provenance du billet "
            <a href="index.php?action=displayOnePost&amp;chapter_id=<?php echo htmlspecialchars($comment['id_chapt']);?>">
                <?php echo htmlspecialchars($comment['chapter_title']); ?>
            </a>".</p>
    </div>

    <?php
}
?>

    <?php $content = ob_get_clean(); ?>
