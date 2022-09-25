<?php
$isRemote = $_SERVER['SERVER_NAME'] != 'testtask64.local';
$currentColumn = [
	'user' => $isRemote ? 'users' : 'testtaskUsers',
	'cart' => $isRemote ? 'carts' : 'testtaskCarts'
];

function connector(){
	if($isRemote){ return new PDO('mysql:host=fdb30.awardspace.net;dbname=4182102_testtask', '4182102_testtask', 'seriy2000-testtask'); }
	else{ return new PDO('mysql:host=database;dbname=aplex', 'developer', '19052000'); }
}
?>
