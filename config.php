<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/php-activerecord/ActiveRecord.php';

	ActiveRecord\Config::initialize(function($cfg) {

		$cfg->set_model_directory($_SERVER['DOCUMENT_ROOT'] . '/src/models');
		$cfg->set_connections([

			'development' => 'mysql://expenses:lambda73@mysql:3306/expenses',
			'test' => 'mysql://expenses:lambda73@mysql/expenses',
			'production' => 'mysql://expenses:lambda73@mysql/expenses'

		]);
		$cfg->set_default_connection('development');

	});

?>