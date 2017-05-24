<?php

namespace Drupal\practice;

use Drupal\Core\Database\Connection;

class dbWrapper {
	public function __construct(Connection $connection) {
		$this->connection = $connection;
	}
	public function read() {
		$result = $this->connection->select ( 'newform_data', 'nda' )->fields ( 'nda' )->execute ();
		return $result->fetchAssoc ();
	}
	public function write($fname, $lname) {
		$this->connection->insert ( 'newform_data' )->fields ( [
				'fname',
				'lname'
		], [
				$fname,
				$lname
		] )->execute ();
	}
}

