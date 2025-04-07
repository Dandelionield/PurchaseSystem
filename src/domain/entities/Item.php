<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';

class Item extends ActiveRecord\Model{

	public static $table_name = 'storage.item'; 

    public static $primary_key = 'item_id'; 

	public static $alias_attribute = array(

		'id' => 'item_id',
		'code' => 'item_code'

    );

	public static $validates_presence_of = array(

		array('item_code', 'message' => 'La cedula es obligatoria.'),
		array('name', 'message' => 'El nombre es obligatorio.')

	);

	public static $validates_length_of = array(

		array('item_code', 'maximum' => 10, 'too_long' => 'Código excede el tamaño maximo de caracteres.'),
		array('name', 'maximum' => 100, 'too_long' => 'Nombre excede el tamaño maximo de caracteres.')

	);

	public static $validates_numericality_of = array(

		array('price', 'greater_than' => 0),
		array('stock', 'greater_than_or_equal_to' => 0)

	);

	public static $scope = array(

		'actives' => array(

			'conditions' => array('state = ?', true)

		)

	);

}

?>