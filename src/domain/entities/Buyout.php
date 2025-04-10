<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';

class Buyout extends ActiveRecord\Model{

	public static $table_name = 'buyout';
	public static $primary_key = 'buyout_id';

	public static $alias_attribute = array(

		'id' => 'buyout_id'

	);

	public static $validates_presence_of = array(

		array('purchase_id', 'message' => 'Compra es obligatoria.'),
		array('item_id', 'message' => 'Item es obligatorio.')

	);

	public static $validates_numericality_of = array(

		array('quantity', 'greater_than' => 0),
		array('total', 'greater_than' => 0)

	);

	public static $belongs_to = array(

		array('purchase', 'class_name' => 'Purchase', 'foreign_key' => 'purchase_id'),
		array('item', 'class_name' => 'Item', 'foreign_key' => 'item_id')

	);

}

?>