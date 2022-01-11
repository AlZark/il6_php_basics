<?php
$games = readFromCsv('play_history.csv');
?>

<div class="grid">

    <label><strong>Game history: </strong></label>
    <?php foreach ($games as $game) : ?>

        <div class="product-wrap">

            <label><strong>Game <?php echo $game[0] ?> result:</strong></label>
            <?php echo $game[1] ?>

            <label><strong>Player choice: </strong></label>
            <?php echo $game[2] ?>

            <label><strong>Pc choice: </strong></label>
            <?php echo $game[3] ?>

        </div>
        <br>

    <?php endforeach; ?>
</div>