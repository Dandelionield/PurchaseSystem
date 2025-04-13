<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/models/Clock.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {

	try {

		$clock = new Clock();

		$clock->save();
		
		$clock = Clock::find_by_id($clock->id);

		header('Content-Type: application/json');

		echo json_encode([

			'success' => true,
			'time' => $clock->clock_date->format('H:i:s')

		]);

	}catch (Exception $e){

		header('Content-Type: application/json');

		echo json_encode([

			'success' => false,
			'error' => 'Error al registrar la hora: ' . $e->getMessage()

		]);

	}

	exit();
}

?>