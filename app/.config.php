<?php 

$connector = $isRemote ? mysqli_connect('fdb30.awardspace.net', '4182102_testtask', 'seriy2000-testtask', '	4182102_testtask') : mysqli_connect('127.0.0.1', 'developer', '19052000', 'aplex') ;

if (!$connector) {
        die("Ошибка подключения к БД. Код ошибки: " . mysqli_connect_error());
        exit;
}   
?>
