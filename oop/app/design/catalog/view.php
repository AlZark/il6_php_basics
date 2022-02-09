</div>

<div class="list-wrapper">
    <h1><?php echo $this->data['catalog']->getTitle(); ?></h1>

    <?php $img = $this->data['catalog']->getImg();
    if ($img != NULL) { ?>
        <img src="<?php echo $this->data['catalog']->getImg(); ?>" width="800"> <br> <?php } ?>
    <p>About: <?php echo $this->data['catalog']->getDescription(); ?> </p>
    <p> <?php echo $this->data['catalog']->getPrice(); ?> Eur</p>
    <p>Year: <?php echo $this->data['catalog']->getYear(); ?></p>
</div>