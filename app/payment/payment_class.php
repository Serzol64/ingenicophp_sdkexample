<?php
require_once '../.config.php';
use Ingenico\Connect\Sdk;

class Payment{
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->data = $connector;
	}
	public function validator($q){}
	public function execute($q){}
}

class Success extends Settings{
	public function validator($q){}
	public function execute($q){}
}
?>
