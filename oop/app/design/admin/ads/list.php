<?php

/**
 * @var \Model\Catalog $ad ;
 */

use Model\Comments;
?>

<table>
    <tr>
        <th>#</th>
        <th>Id</th>
        <th>Title</th>
        <th>Price(Eur)</th>
        <th>Year</th>
        <th>Mileage(km)</th>
        <th>Views</th>
        <th>Status</th>
        <th>CreatedAt</th>
        <th>Comments</th>
        <th>Action</th>
    </tr>

    <form action="<?= $this->url('admin/massAdActions') ?>" method="POST">
        <?php
        foreach ($this->data['ads'] as $ad):
            ?>
            <tr>
                <td><input type="checkbox" name='ad_id[]' value="<?= $ad->getId() ?>"></td>
                <td><?= $ad->getId(); ?></td>
                <td><?= $ad->getTitle(); ?></td>
                <td><?= $ad->getPrice(); ?></td>
                <td><?= $ad->getYear(); ?></td>
                <td><?= $ad->getMileage(); ?></td>
                <td><?= $ad->getViews(); ?></td>
                <td><?= $ad->getActive(); ?></td>
                <td><?= $ad->getCreatedAt(); ?></td>
                <td><?= Comments::getTotalComments($ad->getId()); ?></td>
                <td>
                    <a href="<?= $this->url('admin/adEdit', $ad->getId()) ?>">
                        <i class="fa-solid fa-pen-to-square fa-lg"></i></a>
                    <a href="<?= $this->url('admin/adDelete', $ad->getId())?>">
                        <i class="fa-solid fa-trash-can fa-lg"></i></a>
                </td>
            </tr>

        <?php endforeach; ?>
</table>
        <select name="action">
            <option value="">Choose action</option>
            <option value="1">Enable</option>
            <option value="0">Disable</option>
            <option value="2">Delete</option>
        </select>
        <input type="submit" name="submit" value="Update">

    </form>