<?php $title = 'Erreur de connexion';
ob_start(); ?>

<h2 class="py-5">Erreur de connexion</h2>

<div class="news">
    <div class="alert alert-info">Veuillez vous connecter pour accéder à l'espace d'administration.</div>
    <a href="index.php?page=1">Retour</a>
</div>

<?php $content = ob_get_clean(); ?>
