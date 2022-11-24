<?php

if (!isset($_SESSION['user'])) {
    header("Location: ?page=home");
} 

?>

<section class="main-portal-section">
    <ul class="main-portal-wrapper">
        <li><a href="<?= DIR_PATH ?>/dashboard/">Dashboard</a></li>
        <li><a href="<?= DIR_PATH ?>/mobile/">Mobile</a></li>
    </ul>
</section>