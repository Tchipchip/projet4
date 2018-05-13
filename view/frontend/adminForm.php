<?php $title = 'Connexion administrateur';
ob_start(); ?>

<!-- Connexion admin -->
<h2 class="py-4">Connexion administrateur</h2>

<div class="news">
    <form action="index.php?action=login" method="post" class="connexionAdmin">
     <div class="form-group">  
        <label for="pseudo">Pseudo</label>
        <input class="form-control" type="pseudo" id="pseudo" name="pseudo" required />
        </div>
        <div class="form-group">
        <label for="password">Mot de passe</label>
        <input class="form-control" type="password" name="password" required />
        </div>
        <button type="submit" name="connexion" class="btn btn-primary my-3">Connexion</button>
    </form>
</div>

<?php $content = ob_get_clean(); ?>
