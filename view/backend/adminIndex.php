<?php $title = 'Accueil administrateur';
ob_start(); ?>

<!-- Connexion admin -->
<h2 class="py-4">Bienvenue sur l'interface administrateur !</h2>

<p>Vous pouvez ajouter, modifier ou supprimer des billets en cliquant sur le lien "<strong>Billets</strong>".</p>
<p>Vous pouvez visualiser les commentaires signalés par les utilisateurs et les modifier ou supprimer en cliquant sur le lien "<strong>Commentaires signalés</strong>".</p>


<?php $content = ob_get_clean(); ?>
