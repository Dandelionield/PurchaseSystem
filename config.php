<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/lib/php-activerecord/ActiveRecord.php';

	ActiveRecord\Config::initialize(function($cfg) {

		$cfg->set_model_directory($_SERVER['DOCUMENT_ROOT'] . '/PurchaseSystem/src/domain/entities');
		$cfg->set_connections([

			'development' => 'mysql://expenses:lambda73@localhost/expenses?search_path=super',
			'test' => 'mysql://expenses:lambda73@localhost/expenses?search_path=super,storage,expense',
			'production' => 'mysql://expenses:lambda73@localhost/expenses?search_path=super,storage,expense'

		]);
		$cfg->set_default_connection('development');

	});

	//ActiveRecord\Connection::$quote_identifiers = false;

?>