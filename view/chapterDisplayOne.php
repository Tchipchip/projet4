<?php $title = "Billet et commentaires";
ob_start(); ?>
<!-- Permet de mémoriser le code html qui suit en le mettant dans la variable "content" -->

<a href="index.php?page=1">Retour</a>

<!-- Display chapter -->
<div class="news">
    <h3 class="py-3">
        <?php echo htmlspecialchars($post['chapter_title']); ?>
    </h3>
    <p class="font-italic">publié le
        <?php echo htmlspecialchars($post['chapter_date_fr']); ?> </p>
    <?php
if (!empty($_SESSION['user'])) {
?>
        <a href="index.php?action=editPostForm&amp;chapter_id=<?php echo htmlspecialchars($post['chapter_id']); ?>"><i class="fas fa-pencil-alt pr-3" aria-hidden="true" title="Modifier"></i></a>


        <a href="index.php?action=deletePost&amp;chapter_id=<?php echo htmlspecialchars($post['chapter_id']); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce billet ?'));"><i class="fas fa-trash" aria-hidden="true" title="Supprimer"></i></a>
        <?php
}
?>
        <p>
            <?php echo nl2br($post['chapter_content']); ?>
        </p>
</div>

<!-- Display comments -->
<h2 class="py-4">Commentaires</h2>

<div>
    <form class="mb-5" action="index.php?action=addComment&amp;comment_id=<?php echo htmlspecialchars($post['chapter_id']); ?>" method="post">
        <div class="form-group">
            <label for="author">Auteur</label>
            <input class="form-control" type="text" id="author" name="author" />
        </div>
        <div class="form-group">
            <label for="comment">Commentaire</label>
            <textarea class="form-control" id="comment" name="comment"></textarea>
        </div>
        <button type="submit" class="btn btn-primary my-3">Envoyer</button>
    </form>

    <?php
while ($comment = $comments->fetch()) {
?>
        <div>

            <!-- Reported for admin -->
            <?php
        if ($comment['comment_report'] && !empty($_SESSION['user'])) {
        ?>
                <div>
                    <i class="fas fa-exclamation-triangle fa-2x px-3" aria-hidden="true"></i>Commentaire signalé <i class="fas fa-exclamation-triangle fa-2x px-3" aria-hidden="true"></i>
                </div>
                <?php    
        }
// Reported for users 
        if (empty($_SESSION['user'])) {
        ?>
                <a href="index.php?action=reportComment&amp;comment_id=<?php echo htmlspecialchars($comment['comment_id']); ?>&amp;postId=<?php echo htmlspecialchars($_GET['chapter_id']); ?>"><i class="fas fa-exclamation-circle fa-2x px-3" aria-hidden="true" title='Signaler'></i></a>
                <?php
        }
        ?>
                    <!-- Display author and date of the comment -->
                    <strong><?php echo htmlspecialchars($comment['comment_author']); ?></strong>
                    <p class="font-italic mt-3">le
                        <?php echo htmlspecialchars($comment['comment_date_fr']); ?>
                    </p>
                    <!-- Edit and delete comment by admin -->
                    <?php
        if (!empty($_SESSION['user'])) {
        ?>
                        <a href="index.php?action=editCommentForm&amp;comment_id=<?php echo htmlspecialchars($comment['comment_id']); ?>"><i class="fas fa-pencil-alt" aria-hidden="true" title='Modifier'></i></a>

                        <a href="index.php?action=deleteComment&amp;comment_id=<?php echo htmlspecialchars($comment['comment_id']); ?>&amp;id_chapt=<?php echo htmlspecialchars($comment['id_chapt']); ?>" onclick="return(confirm('Etes-vous sûr de vouloir supprimer ce commentaire ?'));"><i class="fas fa-trash" aria-hidden="true" title='Supprimer' ></i></a>
                        <?php
        }
        ?>
                            <!-- Display content of the comment -->
                            <p class="mt-3">
                                <?php echo htmlspecialchars($comment['comment_content']); ?>
                            </p>
        </div>
        <?php
}
?>
</div>

<!-- Bootstrap’s modal component appears when a comment is reported by a user -->
<?php
if ($reported) {
?>
    <div id="modalSignal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <p>Votre commentaire a été signalé à l'administrateur.</p>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok !</button>
            </div>
        </div>
    </div>
    <?php
}
?>

    <?php $content = ob_get_clean(); ?>
