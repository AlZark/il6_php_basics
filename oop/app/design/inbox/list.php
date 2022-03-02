<?php use Model\User; ?>

<div class="container">
    <a class="menu" href="<?= $this->Url('inbox/sendMessage') ?>">+Send new</a>
    <h2>All chats</h2>
    <?php foreach ($this->data['users'] as $user): ?>
        <hr>
        <div class="list-item">
            <div class="content">
                <?php $contact = new User($user); ?>
                <a href="<?= $this->Url('inbox/conversation?user=' . $user); ?>">
                    <h3>Chat with: <?= $contact->getFullName(); ?></h3></a>
            </div>
            <?php ?>
        </div>
    <?php endforeach; ?>
</div>