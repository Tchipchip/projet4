<?php $title = 'Erreur';
ob_start(); ?>

<a href="index.php?page=1">Retour</a>

<h2 class="py-5">Erreur !</h2>

<div class="news">
    <div class="alert alert-info">
        <?php echo $message; ?>
    </div>

</div>

<?php $content = ob_get_clean(); ?>
