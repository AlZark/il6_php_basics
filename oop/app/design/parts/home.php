<h1>Cars Cars Cars!!!</h1>
<h2> Popular ads</h2>
<div class="pop-catalog-wrap">
<?php
foreach ($this->data['populars'] as $popAd): ?>
    <div class="box">
        <h3><a href="<?php echo $this->Url('catalog/show', $popAd->getSlug()); ?>">
                <?php echo $popAd->getTitle() ?></a></h3>
        <img src="<?= $popAd->getImg(); ?>"  width="200" >
    </div>
<?php endforeach; ?>
</div>

<h2> Latest</h2>
<div class="pop-catalog-wrap">
<?php
foreach ($this->data['latest'] as $latestAd): ?>
    <div class="box">
        <h3><a href="<?php echo $this->Url('catalog/show', $latestAd->getSlug()); ?>">
                <?php echo $latestAd->getTitle() ?></a></h3>
        <img src="<?= $latestAd->getImg();?>" width="200" >
    </div>
<?php endforeach; ?>
</div>
