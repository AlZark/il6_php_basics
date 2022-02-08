<div class="list-wrapper">
    <h1>Daily car ads</h1>
    <ul>
        <?php foreach ($this->data['catalog'] as $catalog): ?>
            <li>
                <h4><a href="<?php echo BASE_URL . 'catalog/show/' . $catalog->getId() ?>">
                    <?php echo $catalog->getTitle()?>
                </a></h4>
                <?php echo $catalog->getPrice() . ' Eur'?><br>
                <?php echo 'Year: ' . $catalog->getYear();?><br>

            </li>
        <?php endforeach; ?>
    </ul>
</div>