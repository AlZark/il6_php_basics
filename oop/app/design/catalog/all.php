<div class="list-wrapper">
    <h1>Daily car ads</h1>

    <div>
        <h3>Filters</h3>
        <?php echo $this->data['form']; ?>
    </div>

    <ul>
        <?php
        foreach ($this->data['catalog'] as $catalog): ?>
            <div class="box">
                <h4><a href="<?php echo $this->Url('catalog/show', $catalog->getSlug()); ?>">
                        <?php echo $catalog->getTitle() ?></a></h4>
                <a href="<?php echo $this->Url('catalog/edit', $catalog->getId()); ?>">Edit</a><br>
                <?php $img = $catalog->getImg();
                if ($img != NULL) { ?>
                    <img src="<?php echo $catalog->getImg(); ?>" width="200"> <br> <?php } ?>
                <?php echo $catalog->getPrice() . ' Eur' ?><br>
                <?php echo 'Year: ' . $catalog->getYear(); ?><br>
            </div>
        <?php endforeach; ?>
    </ul>
</div>