<?php

/**
 * @var \Model\Catalog $catalog ;
 */

?>

<table>

    <tr>
        <th>#</th>
        <th>Id</th>
        <th>Title</th>
        <th>Price</th>
        <th>Year</th>
        <th>VIN</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <form action="<?= $this->url('admin/catalogAction') ?>" method="POST">
        <?php foreach ($this->data['catalogs'] as $catalog): ?>
            <tr>
                <td><input type="checkbox" name='<?= $catalog->getId() ?>'></td>
                <td><?= $catalog->getId(); ?></td>
                <td><?= $catalog->getTitle(); ?></td>
                <td><?= $catalog->getPrice(); ?></td>
                <td><?= $catalog->getYear(); ?></td>
                <td><?= $catalog->getVin(); ?></td>
                <td><?= $catalog->getIsActive(); ?></td>
                <td>
                    <a href="<?= $this->url('admin/catalogEdit', $catalog->getId()) ?>">
                        <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                </td>
            </tr>

        <?php endforeach; ?>
        <select name="action">
            <option value="Disable">Disable</option>
            <option value="Enable">Enable</option>
        </select>
        <input type="submit" name="submit" value="Update">

    </form>
</table>