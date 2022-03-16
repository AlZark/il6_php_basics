<?php use Helper\Url; ?>
<div class="container">
    <ol>
        <?php foreach ($this->data['users'] as $user): ?>
            <li>
                <a href="<?php Url::link('user/show/' . $user->getId()); ?>">
                    <?= $user->getName() . ' ' . $user->getLastName() ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ol>
</div>
