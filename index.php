<?php
    $grid = '';
    $players = '';
    if (isset($_GET['grid']) && $_GET['grid']!='') {
        $grid = $_GET['grid'];
        $players = isset($_GET['players']) && $_GET['players']!='' ? $_GET['players'] : 3;
        $win_number = $grid * $grid;

        $matrix = [];
        $count = 0;

        for($i=0;$i<$grid;$i++) {
            if ($i%2==0) {
                for($j=0;$j<$grid;$j++) {
                    $count++;
                    $matrix[$count] = $j . ', ' . $i;
                }
            }
            else {
                for($j=$grid-1;$j>=0;$j--) {
                    $count++;
                    $matrix[$count] = $j . ', ' . $i;
                }
            }
        }

        $player_history = [];
        $temp = [];
        $winner = false;

        $loop = 0;

        while ($winner==false) {
            $loop++;
            for($i=1;$i<=$players;$i++) {
                $random = rand(1, 6);
                $coordinate = '';
                $winner_status = '';
                if (!isset($temp[$i])) {
                    $temp[$i] = 0;
                }
                $total = $temp[$i] + $random;

                if ($total<=$win_number) {
                    $temp[$i] = $total;
                }

                if (in_array($win_number, $temp)) {
                    $winner = true;
                    $winner_status = 'Winner';
                }

                if (!isset($player_history[$i])) {
                    $player_history[$i] = [
                        'roll_history' => $random,
                        'position_history' => $temp[$i],
                        'coordinate_history' => '('.$matrix[$total].')',
                        'winner_status' => $winner_status,
                    ];
                }
                else {
                    $player_history[$i]['roll_history'] .= ','.$random;
                    $player_history[$i]['position_history'] .= ','.$temp[$i];
                    $player_history[$i]['coordinate_history'] .= ', ('.$matrix[$temp[$i]].')';
                    $player_history[$i]['winner_status'] = $winner_status;
                    $player_history[$i]['total'] = $$total;
                }

                if ($winner) {
                    break;
                }
                
            }
        }
    }
?>
<html>
    <head>
        <title>Dice roll</title>
    </head>
    <body>
        <form action="">
            <label>Grid</label>
            <input type="number" name="grid" value="<?php echo $grid; ?>" />
            <br /><br />
            <button type="submit">Play</button>
        </form>
        <?php
            if (isset($_GET['grid']) && $_GET['grid']!='') {
                ?>
                <h2>Result</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Player No.</th>
                            <th>Roll History</th>
                            <th>Position History</th>
                            <th>Coordinate History</th>
                            <th>Winner Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($player_history as $key=>$val) {
                                ?>
                                <tr>
                                    <td><?php echo $key; ?></td>
                                    <td><?php echo $val['roll_history']; ?></td>
                                    <td><?php echo $val['position_history']; ?></td>
                                    <td><?php echo $val['coordinate_history']; ?></td>
                                    <td><?php echo $val['winner_status']; ?></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
                <?php
            }
        ?>
    </body>
</html>