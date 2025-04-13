<?php

class SessionService {

	private static $encryptionKey = 'nmgdsh45gds45gs3d';
	private static $cookieName = 'CUSTOM_SESSION';

	public static function set(string $key, $value, int $expiry = 86400): void{

		$data = self::_getData();
		$data[$key] = $value;
		self::_saveData($data, $expiry);

	}

	public static function get(string $key){

		$data = self::_getData();
		return $data[$key] ?? null;

	}

	public static function clear(string $key = null): void{

		if ($key){

			$data = self::_getData();
			unset($data[$key]);
			self::_saveData($data);

		}else{

			setcookie(self::$cookieName, '', time() - 3600, '/');

		}

	}

	private static function _getData(): array{

		if (isset($_COOKIE[self::$cookieName])){

			$encryptedData = base64_decode($_COOKIE[self::$cookieName]);
			$iv = substr($encryptedData, 0, 16);
			$payload = substr($encryptedData, 16);
			$decrypted = openssl_decrypt($payload, 'AES-256-CBC', self::$encryptionKey, 0, $iv);

			return json_decode($decrypted, true) ?? [];

		}

		return [];

	}

	private static function _saveData(array $data, int $expiry = 86400): void{

		$iv = openssl_random_pseudo_bytes(16);
		$jsonData = json_encode($data);
		$encrypted = openssl_encrypt($jsonData, 'AES-256-CBC', self::$encryptionKey, 0, $iv);
		$cookieData = base64_encode($iv . $encrypted);
		setcookie(self::$cookieName, $cookieData, time() + $expiry, '/', '', true, true);

	}

}

?>