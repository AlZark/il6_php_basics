<?php
/**
 * @var \Model\Catalog $ad ;
 */
use Model\Comments;
use Model\Rating;
?>

<div class="container">
    <h1>Daily car ads</h1>

    <div>
        <h3>Filters</h3>
        <?php echo $this->data['form']; ?>
    </div>

    <div class="pagination">
        <?php for ($page = 1; $page <= $this->data['allPages']; $page++) { ?>
            <a href="<?= $this->Url('catalog?p=' . $page); ?>">
                <div class="page"><?= $page ?></div>
            </a> <?php } ?>
    </div>

    <?php foreach ($this->data['ads'] as $ad): ?>
        <br>
        <hr>
        <div class="list-item">
            <div class="right">
                <div class="image">
                    <?php $img = $ad->getImg();
                    if ($img != NULL) { ?>
                        <img class="list-img" src="<?= $ad->getImg(); ?>"> <br> <?php } ?>
                </div>
                <div class="description">

                    <div class="item-title">
                        <h2><a href="<?= $this->Url('catalog/show', $ad->getSlug()); ?>">
                                <?= $ad->getTitle();?>
                                <?= ' ('.Comments::getTotalComments($ad->getId()) .')'; ?>
                                </a></h2>
                    </div>
                    <h4><?= Rating::getAdRating($ad->getId()); ?><i class="fa-solid fa-star"></i></h4>
                    <h4><?= 'Year: ' . $ad->getYear(); ?></h4>
                    <h4><?= 'Mileage: ' . $ad->getMileage() . ' km.'; ?></h4>
                    <h3><?= 'Price: ' . $ad->getPrice() . ' Eur.'; ?></h3>

                    <a href="<?= $this->Url('catalog/edit', $ad->getId()); ?>">
                        <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="pagination">
        <?php for ($page = 1; $page <= $this->data['allPages']; $page++) { ?>
            <a href="<?= $this->Url('catalog?p=' . $page); ?>">
                <div class="page"><?= $page ?></div>
            </a> <?php }?>
    </div>
</div>