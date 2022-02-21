<?php

/**
 * @var \Model\Catalog $catalog;
 */

?>

<table>

    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Price</th>
        <th>Year</th>
        <th>VIN</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php foreach ($this->data['catalogs'] as $catalog): ?>
        <tr>
            <td><?= $catalog->getId(); ?></td>
            <td><?= $catalog->getTitle(); ?></td>
            <td><?= $catalog->getPrice(); ?></td>
            <td><?= $catalog->getYear(); ?></td>
            <td><?= $catalog->getVin(); ?></td>
            <td><?= $catalog->getIsActive(); ?></td>
            <td>
                <a href="<?= $this->url('admin/catalogEdit', $catalog->getId())?>">
                    <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
            </td>
        </tr>

    <?php endforeach; ?>
</table>