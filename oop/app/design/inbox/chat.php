<?php

use Model\User;
use Controller\Inbox;

?>

<div class="container">

    <h2>Chat</h2>

    <div class="chat">
        <form action="<?= $this->url('inbox/create') ?>" method="POST">
            <textarea name="content" cols="40" rows="5"></textarea>
            <input type="hidden" name="recipient" value="<?= $this->data['recipient'] ?>"> <br>
            <input type="submit" name="send" value="Send">
        </form>
    </div>

    <?php foreach ($this->data['messages'] as $message) { ?>
        <hr>
        <div class="list-item">
            <?php if ($message->getUserId() == $_SESSION['user_id']) {
                $user = new User($message->getRecipient()) ?>
                <div class="message-from">
                    <h3>To: <?= $user->getFullName(); ?></h3>
                    <p><?= $message->getText(); ?></p>
                    <p><?= $message->getCreatedAt(); ?></p>
                </div>
            <?php } else {
                $user = new User($message->getUserId()) ?>
                <div class="my-message">
                    <h3>From: <?= $user->getFullName(); ?></h3>
                    <p><?= $message->getText(); ?></p>
                    <p><?= $message->getCreatedAt(); ?></p>
                </div>
            <?php } ?>
        </div>
        <?php
        if ($message->getRecipient() == $_SESSION['user_id'] && $message->getRead == 0) {
            $db = new Inbox();
            $db->changeReadStatus($message->getId());
        }
    } ?>
</div>