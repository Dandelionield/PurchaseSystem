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

		array('user_dni', 'message' => 'La cedula es obligatoria.'),
		array('name', 'message' => 'El nombre es obligatorio.')

	);

	public static $validates_length_of = array(

		array('user_dni', 'maximum' => 20, 'too_long' => 'Cedula excede el tamaño maximo de caracteres.'),
		array('name', 'maximum' => 100, 'too_long' => 'Nombre excede el tamaño maximo de caracteres.'),
		array('email', 'maximum' => 100, 'too_long' => 'Email excede el tamaño maximo de caracteres.'),
		array('address', 'maximum' => 100, 'too_long' => 'Direccion excede el tamaño maximo de caracteres.')

	);

	public static $validates_uniqueness_of = array(

		array('email', 'message' => 'Correo ya registrado')

	);

	static $validates_numericality_of = array(

		array('user_dni', 'only_integer' => true)

	);

	static $has_many = array(

		array('purchases', 'class_name' => 'Purchase', 'foreign_key' => 'user_dni')

	);

	public static $scope = array(

		'actives' => array(

			'conditions' => array('state = ?', true)

		)

	);

}

?>