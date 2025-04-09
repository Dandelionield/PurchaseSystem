<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/config.php';

class Employee extends ActiveRecord\Model{

	public static $table_name = 'super.employee'; 

    public static $primary_key = 'employee_code'; 

	public static $alias_attribute = array(

		'code' => 'employee_code',
		'dni' => 'user_dni',
		'admin' => 'admin',  // Mapeo explícito
		'state' => 'state'

    );

    // Desactiva timestamp automático (created_at/updated_at)
    public static $disable_auto_increment = true;

	public static $validates_presence_of = array(

		array('employee_code', 'message' => 'La cedula es obligatoria.'),
		array('password', 'message' => 'Contraseña es obligatoria.'),
		array('admin', 'message' => 'El rol de administrador es requerido.')

	);

	public static $validates_length_of = array(

		array('employee_code', 'maximum' => 10, 'too_long' => 'Código excede el tamaño maximo de caracteres.'),
		array('password', 'maximum' => 30, 'too_long' => 'Contraseña excede el tamaño maximo de caracteres.')

	);

	public static $has_one = array(

		array('user', 'class_name' => 'User', 'foreign_key' => 'user_dni')

	);/**/

	public static $has_many = array(

		array('purchases', 'class_name' => 'Purchase', 'foreign_key' => 'employee_code')

	);

	public static $scope = array(

		'actives' => array(

			'conditions' => array('state = ?', true)

		)

	);

}

?>