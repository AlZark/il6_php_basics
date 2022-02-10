</div>

<div class="list-wrapper">
    <h1><?= $this->data['catalog']->getTitle(); ?></h1>

    <?php $img = $this->data['catalog']->getImg();
    if ($img != NULL) { ?>
        <img src="<?= $this->data['catalog']->getImg(); ?>" width="800"> <br> <?php } ?>
    <p>About: <?= $this->data['catalog']->getDescription(); ?> </p>
    <p> <?= $this->data['catalog']->getPrice(); ?> Eur</p>
    <p>Year: <?= $this->data['catalog']->getYear(); ?></p>
</div>