<?php
$games = readFromCsv('play_history.csv');

$data = array_reverse($games, true);
$counter = 0;
$rez = [1 => 0, 2 => 0];
foreach ($data as $row) {
    if (!empty($row)) {
        if ($row[1] == "Player wins!") {
            $rez[1]++;
        } elseif ($row[1] == "PC wins!") {
            $rez[2]++;
        }
        $counter++;
        if ($counter > 9) {
            break;
        }
    }
}


echo '<h2>' . 'Last 10 games stats:' . '</h2>';
echo 'Player 1 ' . $rez[1] . ':' . $rez[2] . ' Player 2';
echo '<br>';
echo '<br>';

?>

    <div class="grid">


        <h2>Game history: </h2>
        <?php foreach ($games as $game) : ?>
            <br>


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