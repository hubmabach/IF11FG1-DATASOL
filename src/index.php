<?php
    require_once('./includes/global.php');
    
    include_once('./templates/html_start.php');
    include_once('./templates/navigation.php');
?>

<?php include_once('./templates/html_start.php'); ?>
<?php include_once('./templates/navigation.php'); ?>

<div class="container" style="margin-top: 30px;">
    <?php include_once("./includes/router.php"); ?>
</div>

<?php include_once('./templates/html_end.php'); ?>