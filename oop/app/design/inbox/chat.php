<?php
use Model\User;
use Controller\Inbox;
$user = new User($_GET['user']);
?>

<div class="container">

    <h2>Chat with <?= $user->getFullName(); ?></h2>
    <div class="chat">
        <form action="<?= $this->url('inbox/create') ?>" method="POST">
            <textarea name="content" cols="40" rows="5"></textarea>
            <input type="hidden" name="recipient_id" value="<?= $user->getId() ?>"> <br>
            <input type="submit" name="send" value="Send">
        </form>
    </div>

    <div class="chat-wrapper">
    <?php foreach ($this->data['messages'] as $message) { ?>
        <?php if ($message->getSenderId() == $_SESSION['user_id']) {
            $user = new User($message->getRecipientId()) ?>
            <div class="message-wrapper">
                <div class="message-sent">
                    <p class="content"><?= $message->getText(); ?></p>
                    <p class="time"><?= $message->getCreatedAt(); ?></p>
                </div>
            </div>
        <?php } else { $user = new User($message->getSenderId()) ?>
            <div class="message-wrapper">
                <div class="message-received">
                    <p class="content"><?= $message->getText(); ?></p>
                    <p class="time"><?= $message->getCreatedAt(); ?></p>
                </div>
            </div>
        <?php } ?>

        <?php
        if ($message->getRecipientId() == $_SESSION['user_id'] && $message->getRead == 0) {
            $db = new Inbox();
            $db->changeReadStatus($message->getId());
        }
        } ?>
    </div>
</div>