<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/models/Clock.php';

$clock_row_url = '/src/components/Clock/ClockRow/';

?>

<link rel="stylesheet" href="<?=$clock_row_url?>clock_row.component.css">
<script src="<?=$clock_row_url?>clock_row.component.js"></script>

<?php

function ClockRow(Clock $clock): string{

    ob_start();
    $time = date('H:i:s', strtotime($clock->clock_date));

?>
    <tr class="clock-row">

        <td><?=$clock->clock_date->format('H:i:s')?></td>

    </tr>

<?php

    return ob_get_clean();

}

?>