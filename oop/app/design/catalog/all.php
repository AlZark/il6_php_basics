<div class="container">
    <h1>Daily car ads</h1>

    <div>
        <h3>Filters</h3>
        <?php echo $this->data['form']; ?>
    </div>

    <div class="pagination">

        <?php for($page = 1; $page <= $this->data['allPages']; $page++){ ?>

            <a href="<?php echo $this->Url('catalog?p=' . $page); ?>">
                <div class="page"><?php echo $page ?></div> </a> <?php } ?>

    </div>

    <?php foreach ($this->data['catalog'] as $catalog): ?>
        <br>
        <hr>
        <div class="list-item">
            <div class="right">
            <div class="image">
            <?php $img = $catalog->getImg();
                if ($img != NULL) { ?>
                    <img class="list-img" src="<?php echo $catalog->getImg(); ?>"> <br> <?php } ?>
            </div>
            <div class="description">

                <div class="item-title">
                <h2><a href="<?php echo $this->Url('catalog/show', $catalog->getSlug()); ?>">
                        <?php echo $catalog->getTitle() ?></a></h2>
                </div>

                <h4><?php echo 'Year: ' . $catalog->getYear(); ?></h4>
                <h4><?php echo 'Mileage: ' . $catalog->getMileage() . ' km.'; ?></h4>
                <h3><?php echo 'Price: ' . $catalog->getPrice() . ' Eur.'; ?></h3>

                <a href="<?php echo $this->Url('catalog/edit', $catalog->getId()); ?>">
                    <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
            </div>
            </div>
        </div>
        <?php endforeach; ?>

    <div class="pagination">

        <?php for($page = 1; $page <= $this->data['allPages']; $page++){ ?>

        <a href="<?php echo $this->Url('catalog?p=' . $page); ?>">
            <div class="page"><?php echo $page ?></div> </a> <?php } ?>

    </div>
</div>