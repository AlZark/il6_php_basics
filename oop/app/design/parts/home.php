<?php use Model\Rating; ?>
<div class="container">
    <h1>Cars Cars Cars!!!</h1>
    <h2>Popular car ads</h2>

    <?php foreach ($this->data['populars'] as $popAd): ?>
    <hr>
    <div class="list-item">
        <div class="right">
            <div class="image">
                <?php $img = $popAd->getImg();
                    if ($img != NULL) { ?>
                        <img class="list-img" src="<?= $popAd->getImg(); ?>"> <?php } ?>
            </div>
            <div class="description">
                <div class="item-title">
                    <h2><a href="<?= $this->Url('catalog/show', $popAd->getSlug()); ?>">
                            <?= $popAd->getTitle() ?></a></h2>
                </div>
                <h4><?= Rating::getAdRating($popAd->getId()); ?><i class="fa-solid fa-star"></i></h4>
                <h4><?= 'Year: ' . $popAd->getYear(); ?></h4>
                <h4><?= 'Mileage: ' . $popAd->getMileage() . ' km.'; ?></h4>
                <h3><?= 'Price: ' . $popAd->getPrice() . ' Eur.'; ?></h3>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <br>

    <h2>Latest car ads</h2>
    <?php foreach ($this->data['latest'] as $latestAd): ?>
    <hr>
    <div class="list-item">
        <div class="right">
            <div class="image">
                <?php $img = $latestAd->getImg();
                if ($img != NULL) { ?>
                    <img class="list-img" src="<?= $latestAd->getImg(); ?>"> <?php } ?>
            </div>
            <div class="description">
                <div class="item-title">
                    <h2><a href="<?= $this->Url('catalog/show', $latestAd->getSlug()); ?>">
                            <?= $latestAd->getTitle() ?></a></h2>
                </div>
                <h4><?= Rating::getAdRating($latestAd->getId()); ?><i class="fa-solid fa-star"></i></h4>
                <h4><?= 'Year: ' . $latestAd->getYear(); ?></h4>
                <h4><?= 'Mileage: ' . $latestAd->getMileage() . ' km.'; ?></h4>
                <h3><?= 'Price: ' . $latestAd->getPrice() . ' Eur.'; ?></h3>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
