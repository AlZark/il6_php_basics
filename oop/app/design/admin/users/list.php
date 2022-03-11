<?php

/**
 * @var \Model\User $user ;
 */

?>

<div class="container">

    <table id="admin">

        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Full name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Role</th>
            <th>Action</th>
        </tr>

        <form action="<?= $this->url('admin/massUserActions') ?>" method="POST">
            <?php foreach ($this->data['users'] as $user): ?>
                <tr>
                    <td><input type="checkbox" name="user_id[]" value='<?= $user->getId() ?>'></td>
                    <td><?= $user->getId(); ?></td>
                    <td><?= $user->getFullName(); ?></td>
                    <td><?= $user->getEmail(); ?></td>
                    <td><?= $user->getPhone(); ?></td>
                    <td><?= $user->getActive() === 1 ? 'Active' : 'Disabled'; ?></td>
                    <td><?= $user->getRoleId() === 1 ? 'Admin' : 'User' ?></td>
                    <td>
                        <a href="<?= $this->url('admin/userEdit', $user->getId()) ?>">
                            <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                        <a href="<?= $this->url('admin/userDelete', $user->getId()) ?>">
                            <i class="fa-solid fa-trash-can fa-lg"></i></a>
                    </td>
                </tr>

            <?php endforeach; ?>
            <select name="action">
                <option value="">Choose action</option>
                <option value="1">Enable</option>
                <option value="0">Disable</option>
                <option value="2">Delete</option>
            </select>
            <input type="submit" name="submit" value="Update">

        </form>
    </table>

</div>