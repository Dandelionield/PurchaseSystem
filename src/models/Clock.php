<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

class Clock extends ActiveRecord\Model{

	public static $table_name = 'clock';
	public static $primary_key = 'clock_id';

	public static $alias_attribute = array(

		'id' => 'clock_id',

	);

}

?>