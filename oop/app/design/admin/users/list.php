<?php

/**
 * @var \Model\User $user;
 */

?>

<table>

    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php foreach ($this->data['users'] as $user): ?>
<tr>
    <td><?= $user->getId(); ?></td>
    <td><?= $user->getName(); ?></td>
    <td><?= $user->getLastName(); ?></td>
    <td><?= $user->getEmail(); ?></td>
    <td><?= $user->getPhone(); ?></td>
    <td><?= $user->getIsActive(); ?></td>
    <td>
        <a href="<?= $this->url('admin/userEdit', $user->getId())?>">
            <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
    </td>
</tr>

<?php endforeach; ?>
</table>