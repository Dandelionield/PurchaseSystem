<?php

	$clock_url = '/src/components/Clock/';

?>

<link rel="stylesheet" href="<?=$clock_url?>clock.component.css">
<script src="<?=$clock_url?>clock.component.js"></script>

<?php

function ClockComponent(): string{

	ob_start();

?>

	<div class="clock" id="clock"><?=date('H:i:s')?></div>

<?php

	return ob_get_clean();

}

?>