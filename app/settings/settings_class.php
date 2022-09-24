<?php
require_once '../.config.php';
use Ingenico\Connect\Sdk;

class Settings{
	public $data;
	
	public function __construct(){
		parent::__construct();
		$this->data = $connector;
	}
	public function send($q){
		
	}
	public function validator($q){
		
	}
}

class Form extends Settings{
	public function send($q){}
	public function validator($q){}
}
class Login extends Settings{
	public function send($q){}
	public function validator($q){}
}
?>
