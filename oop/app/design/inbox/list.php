<?php use Model\User; ?>

<div class="container">
    <a class="menu" href="<?= $this->Url('inbox/sendMessage') ?>">+Send new</a>
    <h2>All messages</h2>
    <?php foreach ($this->data['messages'] as $message): ?>
        <hr>
        <div class="list-item">
            <div class="content">
                <?php if ($message->getUserId() == $_SESSION['user_id']) {
                    $user = new User($message->getRecipient()) ?>
                    <h3>To: <?= $user->getFullName(); ?></h3>
                <?php } else {
                    $user = new User($message->getUserId()) ?>
                    <h3>From: <?= $user->getFullName(); ?></h3>
                <?php } ?>
            </div>
            <p><?= $message->getText(); ?></p>
            <p><?= $message->getCreatedAt(); ?></p>
            <a href="<?= $this->Url('inbox/sendMessage?to='.$user->getId()); ?>">
                <i class="fa-solid fa-reply">Reply</i></a>

            <?php if($message->getRecipient() == $_SESSION['user_id']){ ?>
            <a href="<?= $this->Url('inbox/changeReadStatus?id='.$message->getId()); ?>">
                <?php if($message->getRead() != 1){ ?>
                    <i class="fa-solid fa-reply">Mark as read</i></a>
                <?php }else{ ?>
                    <i class="fa-solid fa-reply">Mark as unread</i></a>
                <?php }} ?>
        </div>
    <?php endforeach; ?>
</div>
