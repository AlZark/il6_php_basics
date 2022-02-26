<?php

use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Model\Comments;
use Model\User;

?>
<div class="container">
    <h1><?= $this->data['ads']->getTitle(); ?></h1>

    <?php $img = $this->data['ads']->getImg();
    if ($img != NULL) { ?>
        <img src="<?= $img ?>" width="800"> <br> <?php } ?>
    <p>About: <?= $this->data['ads']->getDescription(); ?> </p>

    <?php
    $db = new Manufacturer();
    $manufacturer = $db->load($this->data['ads']->getManufacturerId());
    $name = $manufacturer->getName();
    ?>
    <p><strong>Manufacturer: </strong><?= $name ?></p>

    <?php
    $db = new Model();
    $model = $db->load($this->data['ads']->getModelId());
    $name = $model->getName();
    ?>
    <p><strong>Model: </strong><?= $name ?> </p>

    <?php
    $db = new Type();
    $type = $db->load($this->data['ads']->getTypeId());
    $name = $type->getName();
    ?>
    <p><strong>Type: </strong><?= $name ?> </p>

    <p><strong>Mileage: </strong><?= $this->data['ads']->getMileage(); ?> km.</p>

    <p><strong>Color: </strong><?= $this->data['ads']->getColor(); ?> </p>

    <p><strong>Price: </strong><?= $this->data['ads']->getPrice(); ?> Eur</p>
    <p><strong>Year: </strong><?= $this->data['ads']->getYear(); ?></p>

</div>

<div class="container">
    <div>
        <h2>Write a comment</h2>
        <form action="<?= $this->url('catalog/comment') ?>" method="POST">
            <input type="hidden" name='catalog_id' value="<?= $this->data['ads']->getId() ?>">
            <textarea name="content" rows="4" cols="50"></textarea> <br>

            <p>Verify that you're not a toaster before posting</p>
            <input type="hidden" name='number1' value="<?= $number1 = rand(0, 20); ?>">
            <input type="hidden" name='number2' value="<?= $number2 = rand(0, 20); ?>">
            <?php echo $number1 . ' + ' . $number2 . ' = ' ?>
            <input type="number" name='answer' placeholder="Your answer">
            <input type="submit" name="submit" value="Submit">
        </form>
    </div>

    <div>
        <h2>Comments <?php echo ' ('.Comments::getTotalComments($this->data['ads']->getId()) .')'; ?></h2>
        <?php $comments = Comments::getAllCatalogComments($this->data['ads']->getId());
        foreach ($comments as $comment):?>
            <div class="author">
                <?php $user_db = new User($comment['user_id']); ?>
                <p><strong><?= $user_db->getFullName(); ?> </strong> <?= $comment['ip']; ?> </p>
            </div>
            <div class="comment">
                <?= $comment['content']; ?>
            </div>
            <div class="date"><p><?= $comment['created_at']; ?></p></div>
            <hr>
        <?php endforeach; ?>
    </div>
</div>

<div class="container">
    <h2>Related ads</h2>

    <ul>
        <?php foreach ($this->data['related'] as $ad): ?>
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