<?php
    use Model\Catalog;
    use Model\User;
?>
<div class="container">
    <h1>Dashboard</h1>

    <div class="ads-panel">
        <h2><a href="<?= $this->Url('admin/catalogs')?>">Ads</a></h2>
        <p>All: <?= Catalog::totalAds() ?></p>
        <p>Active: <?= Catalog::totalActiveAds() ?></p>
        <p>New: <?= Catalog::totalNewAds() ?></p>
    </div>

    <div class="users-panel">
        <h2><a href="<?= $this->Url('admin/users')?>">Users</a></h2>
        <p>All: <?= User::totalUsers() ?></p>
        <p>Active: <?= User::totalActiveUsers() ?></p>
        <p>New: <?= User::totalNewUsers() ?></p>
    </div>

</div>