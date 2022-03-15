<?php
use Model\Manufacturer;
use Model\Model;
use Model\Type;
use Model\Comments;
use Model\User;

$adOwner = $this->data['ads']->getUserId();
$userId = $_SESSION['user_id'];

?>
<div class="container">
    <h1><?= $this->data['ads']->getTitle(); ?></h1>

    <div class="rating">
        <div class="score">
            <?php $rating = $this->data['rating']; ?>
            <h2><?= 'Rating: ' . $rating . '/5';
                //TODO rewrite to match example that we did in class
                for ($i = 1; $i <= 5; $i++) {
                    if ($i > $rating && $i < $rating + 1) {
                        echo '<i class="fa-regular fa-star-half-stroke"></i>';
                    } elseif ($i <= $rating) {
                        echo '<i class="fa-solid fa-star"></i>';
                    } else {
                        echo '<i class="fa-regular fa-star"></i>';
                    }
                } ?>
            </h2>
        </div>
        <div class="rate">
            <?= $this->data['rate']; ?>
        </div>
        <?php if ($this->isUserLoggedIn()): ?>
        <div class="favorite">
            <form action="<?= $this->url('catalog/favorite') ?>" method="POST">
                <input type="hidden" name="ad_id" value="<?= $this->data['ads']->getId() ?>">
                <button class="heart" type="submit" name="submit">
                    <?php if ($this->data['favorited']): ?>
                        <i class="fa-solid fa-heart fa-lg"></i>
                    <?php else: ?>
                        <i class="fa-regular fa-heart fa-lg"></i>
                    <?php endif; ?>
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <?php
        $db = new Manufacturer();
        $manufacturer = $db->load($this->data['ads']->getManufacturerId());
        $name = $manufacturer->getName();

        $db = new Model();
        $model = $db->load($this->data['ads']->getModelId());
        $name = $model->getName();

        $db = new Type();
        $type = $db->load($this->data['ads']->getTypeId());
        $name = $type->getName();
    ?>

    <div class="ad-content">
        <?php $img = $this->data['ads']->getImg();
        if ($img != NULL) { ?>
            <img src="<?= $img ?>" width="800"> <br>
        <?php } ?>
        <h2>About</h2>
        <p><strong>Description: </strong><?= $this->data['ads']->getDescription(); ?> </p>
        <p><strong>Manufacturer: </strong><?= $name ?></p>
        <p><strong>Model: </strong><?= $name ?> </p>
        <p><strong>Type: </strong><?= $name ?> </p>
        <p><strong>Mileage: </strong><?= $this->data['ads']->getMileage(); ?> km.</p>
        <p><strong>Color: </strong><?= $this->data['ads']->getColor(); ?> </p>
        <p><strong>Price: </strong><?= $this->data['ads']->getPrice(); ?> Eur</p>
        <p><strong>Year: </strong><?= $this->data['ads']->getYear(); ?></p>
    </div>

    <div class="private-message">
        <?php if ($adOwner != $userId) { ?>
            <i class="fa-solid fa-message fa-lg"></i>
            <a href="<?= $this->Url('inbox/conversation?user=' . $adOwner); ?>">Send PM</a>
        <?php } ?>
    </div>

    <div class="container-comments">
        <div>

            <?= $this->data['comment']; ?>

        </div>

        <div>
            <h2>Comments <?= ' (' . Comments::getTotalComments($this->data['ads']->getId()) . ')'; ?></h2>
            <?php $comments = Comments::getAllCatalogComments($this->data['ads']->getId());
            foreach ($comments as $comment): ?>
                <div class="author">
                    <?php $user_db = new User($comment['user_id']); ?>
                    <p><strong><?= $user_db->getFullName(); ?> </strong> <?= $comment['ip']; ?>
                        <?php if($comment['user_id'] == $userId || $adOwner == $userId): ?>
                        <a href="<?= $this->url('catalog/commentDelete', $comment['id']) ?>">
                            <i class="fa-solid fa-trash-can fa-lg"></i></a>
                        <?php endif; ?>
                    </p>
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
                    <h4><a href="<?= $this->Url('catalog/show', $ad->getSlug()); ?>">
                            <?= $ad->getTitle() ?></a></h4>
                    <a href="<?= $this->Url('catalog/edit', $ad->getId()); ?>">Edit</a><br>
                    <?php $img = $ad->getImg();
                    if ($img != NULL) { ?>
                        <img src="<?= $ad->getImg(); ?>" width="200"> <br> <?php } ?>
                    <?= $ad->getPrice() . ' Eur' ?><br>
                    <?= 'Year: ' . $ad->getYear(); ?><br>
                </div>
            <?php endforeach; ?>
        </ul>
    </div>
</div>