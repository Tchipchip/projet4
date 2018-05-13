<?php $title = 'Modifier un billet';
// Permet de mémoriser le code html qui suit en le mettant dans la variable "content"
ob_start(); ?>

<!-- Modification d'un chapitre -->
<h2 class="py-4">Modifier le billet</h2>
<a href="index.php?page=1">Annuler</a>

<div>
    <form action="index.php?action=editPost&amp;chapter_id=<?php echo htmlspecialchars($_GET['chapter_id']) ?>" method="post">
        <div class="form-group mt-4">
            <label for="title">Titre</label>
            <input class="form-control" type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['chapter_title'] )?>" />
        </div>
        <div class="form-group">
            <label for="content">Contenu</label>
            <textarea class="form-control" id="content" name="content"><?php echo htmlspecialchars($post['chapter_content']) ?></textarea>
        </div>
        <input name="token" type="hidden" value="<?php echo $this->getToken(); ?>" />
        <!-- this est ici le BackendController -->
        <button type="submit" class="btn btn-primary mt-3" name="newPost">Modifier</button>

    </form>
</div>

<?php $content = ob_get_clean(); ?>
