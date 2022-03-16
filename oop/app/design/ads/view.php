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
        $manufacturer = $manufacturer->getName();

        $db = new Model();
        $model = $db->load($this->data['ads']->getModelId());
        $model = $model->getName();

        $db = new Type();
        $type = $db->load($this->data['ads']->getTypeId());
        $type = $type->getName();
    ?>

    <div class="ad-content">
        <?php $img = $this->data['ads']->getImg();
        if ($img != NULL) { ?>
            <img src="<?= $img ?>" width="800"> <br>
        <?php } ?>
        <h2>About</h2>
        <p><strong>Description: </strong><?= $this->data['ads']->getDescription(); ?> </p>
        <p><strong>Manufacturer: </strong><?= $manufacturer ?></p>
        <p><strong>Model: </strong><?= $model ?> </p>
        <p><strong>Type: </strong><?= $type ?> </p>
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
        <?php if($this->isUserLoggedIn()): ?>
        <div class="comment">
            <form action="<?= $this->url('catalog/leaveComment') ?>" method="POST">
                <h2>Comment:</h2>
                <input type="hidden" name="ad_id" value="<?= $this->data['ads']->getId() ?>">
                <textarea name="content" cols="60" rows="5"></textarea><br>
                <label>Verify that you're not a toaster before posting</label><br>
                <input type="hidden" name="number1" value="<?= $number1 = rand(0, 20) ?>">
                <input type="hidden" name="number2" value="<?= $number2 = rand(0, 20) ?>">
                <label><?= $number1 . ' + ' . $number2 . ' = ' ?></label>
                <input type="number" name="answer" placeholder="Your answer"><br>
                <input type="submit" name="submit" value="Comment">
            </form>
        </div>
        <?php endif; ?>
        <div class="display-comments">
            <h2>Comments <?= ' (' . Comments::getTotalComments($this->data['ads']->getId()) . ')'; ?></h2>
            <?php $comments = Comments::getAllCatalogComments($this->data['ads']->getId());
            foreach ($comments as $comment): ?>
                <div class="author">
                    <?php $user_db = new User($comment['user_id']); ?>
                    <p><strong><?= $user_db->getFullName(); ?> </strong> <?= $comment['ip']; ?>
                        <?php if($comment['user_id'] == $userId): ?>
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