<?php $title = 'Modifier un commentaire';
ob_start(); ?>

<!-- Modification du commentaire -->
<h2 class="py-4">Modifier le commentaire</h2>
<a href="index.php?action=displayReportedCommentsAdmin">Annuler</a>

<div>
    <form action="index.php?action=editComment" method="post">
        <div class="form-group mt-4">
            <label for="comment">Commentaire</label>
            <input class="form-control" id="comment" name="comment" value="<?php echo nl2br(htmlspecialchars($comment['comment_content'])) ?>" />
        </div>
        <input name="id_post" type="hidden" value="<?php echo (htmlspecialchars($comment['id_chapt'])) ?>" />
        <input name="id" type="hidden" value="<?php echo (htmlspecialchars($comment['comment_id'])) ?>" />
        <input name="token" type="hidden" value="<?php echo $this->getToken(); ?>" />
        <!-- this est ici le BackendController -->
        <button type="submit" class="btn btn-primary mt-3" name="newComment">Modifier</button>

    </form>
</div>

<?php $content = ob_get_clean(); ?>
