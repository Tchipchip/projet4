<div class="pagination">
    <?php
/** Nombre de billet divisé par 5 arrondi au nombre supérieur */    
$nbPost = ceil($nbPost/5); 
for ($i = 1; $i < $nbPost + 1; $i++) {
?>

        <div class="ml-2 px-2 border border-primary rounded">
            <a href='index.php?page=<?php echo $i; ?>'>
                <?php echo $i; ?>
            </a>
        </div>
        <?php
}
?>
</div>
