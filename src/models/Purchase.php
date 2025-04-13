<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

class Purchase extends ActiveRecord\Model{

	public static $table_name = 'purchase';
	public static $primary_key = 'purchase_id';

	public static $alias_attribute = array(

		'id' => 'purchase_id',
		'user' => 'user_dni'

	);

	public static $validates_presence_of = array(

		array('user_dni', 'message' => 'User  is required.')

	);

	public static $belongs_to = array(

		array('user', 'class_name' => 'User', 'foreign_key' => 'user_dni')

	);

	public static $validates_numericality_of = array(

		array('total', 'greater_than_or_equal_to' => 0)

	);

}

?>