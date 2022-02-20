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
                        <img class="list-img" src="<?php echo $popAd->getImg(); ?>"> <?php } ?>
            </div>
            <div class="description">
                <div class="item-title">
                    <h2><a href="<?php echo $this->Url('catalog/show', $popAd->getSlug()); ?>">
                            <?php echo $popAd->getTitle() ?></a></h2>
                </div>
                <h4><?php echo 'Year: ' . $popAd->getYear(); ?></h4>
                <h4><?php echo 'Mileage: ' . $popAd->getMileage() . ' km.'; ?></h4>
                <h3><?php echo 'Price: ' . $popAd->getPrice() . ' Eur.'; ?></h3>
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
                    <img class="list-img" src="<?php echo $latestAd->getImg(); ?>"> <?php } ?>
            </div>
            <div class="description">
                <div class="item-title">
                    <h2><a href="<?php echo $this->Url('catalog/show', $latestAd->getSlug()); ?>">
                            <?php echo $latestAd->getTitle() ?></a></h2>
                </div>
                <h4><?php echo 'Year: ' . $latestAd->getYear(); ?></h4>
                <h4><?php echo 'Mileage: ' . $latestAd->getMileage() . ' km.'; ?></h4>
                <h3><?php echo 'Price: ' . $latestAd->getPrice() . ' Eur.'; ?></h3>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
