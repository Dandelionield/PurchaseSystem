<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';

class User extends ActiveRecord\Model{

	public static $table_name = 'user'; 

    public static $primary_key = 'user_dni'; 

	public static $alias_attribute = array(

		'dni' => 'user_dni'

    );

    // Desactiva timestamp automático (created_at/updated_at)
    public static $disable_auto_increment = true;

	public static $validates_presence_of = array(

		array('user_dni', 'message' => 'DNI is required.'),
		array('name', 'message' => 'Name is required.'),
		array('email', 'message' => 'Email is required.'),
		array('password', 'message' => 'Password is required.')

	);

	public static $validates_length_of = array(

		array('user_dni', 'maximum' => 20, 'too_long' => 'DNI surpases the maximum length required.'),
		array('name', 'maximum' => 100, 'too_long' => 'Name surpases the maximum length required.'),
		array('email', 'maximum' => 100, 'too_long' => 'Email surpases the maximum length required.'),
		array('password', 'maximum' => 30, 'too_long' => 'Password surpases the maximum length required.')

	);

	public static $validates_uniqueness_of = array(

		array('email', 'message' => 'Email already signed up.')

	);

	static $validates_numericality_of = array(

		array('user_dni', 'only_integer' => true)

	);

	static $has_many = array(

		array('purchases', 'class_name' => 'Purchase', 'foreign_key' => 'user_dni')

	);

}

?>