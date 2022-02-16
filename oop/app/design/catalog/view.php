<div class="list-wrapper">
    <h1><?= $this->data['catalog']->getTitle(); ?></h1>

    <?php $img = $this->data['catalog']->getImg();
    if ($img != NULL) { ?>
        <img src="<?= $this->data['catalog']->getImg(); ?>" width="800"> <br> <?php } ?>
    <p>About: <?= $this->data['catalog']->getDescription(); ?> </p>
    <p> <?= $this->data['catalog']->getPrice(); ?> Eur</p>
    <p>Year: <?= $this->data['catalog']->getYear(); ?></p>
</div>

<div class="list-wrapper">
    <h2>Related ads</h2>

    <ul>
        <?php
        foreach ($this->data['related'] as $ad): ?>
            <div class="box">
                <h4><a href="<?php echo $this->Url('catalog/show', $ad->getSlug()); ?>">
                        <?php echo $ad->getTitle() ?></a></h4>
                <a href="<?php echo $this->Url('catalog/edit', $ad->getId()); ?>">Edit</a><br>
                <?php $img = $ad->getImg();
                if ($img != NULL) { ?>
                    <img src="<?php echo $ad->getImg(); ?>" width="200"> <br> <?php } ?>
                <?php echo $ad->getPrice() . ' Eur' ?><br>
                <?php echo 'Year: ' . $ad->getYear(); ?><br>
            </div>
        <?php endforeach; ?>
    </ul>
</div>