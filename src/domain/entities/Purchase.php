<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';

class Purchase extends ActiveRecord\Model{

	public static $table_name = 'expense.purchase';
	public static $primary_key = 'purchase_id';

	public static $alias_attribute = array(

		'id' => 'purchase_id',
		'code' => 'purchase_code'

	);

	public static $validates_presence_of = array(

		array('user_dni', 'message' => 'Usuario es obligatorio.'),
		array('employee_code', 'message' => 'Empleado es obligatorio.')

	);

	public static $belongs_to = array(

		array('user', 'class_name' => 'User', 'foreign_key' => 'user_dni'),
		array('employee', 'class_name' => 'Employee', 'foreign_key' => 'employee_code')

	);

	public static $has_many = array(

		array('buyouts', 'class_name' => 'Buyout', 'foreign_key' => 'purchase_id')

	);

	public static $validates_numericality_of = array(

		array('total', 'greater_than_or_equal_to' => 0)

	);

}

?>