<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/lib/php-activerecord/ActiveRecord.php';

	ActiveRecord\Config::initialize(function($cfg) {

		$cfg->set_model_directory($_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/models');
		$cfg->set_connections([

			'development' => 'mysql://expenses:lambda73@localhost/expenses',
			'test' => 'mysql://expenses:lambda73@localhost/expenses',
			'production' => 'mysql://expenses:lambda73@localhost/expenses'

		]);
		$cfg->set_default_connection('development');

	});

?>