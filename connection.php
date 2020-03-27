<?php
$db_host="127.0.0.1"; //localhost server 
$db_user="root";	//database username
$db_password="";	//database password   
$db_name="php_pdo_login_db";	//database name

try
{
	$db=new PDO("mysql:host={$db_host};dbname={$db_name}",$db_user,$db_password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOEXCEPTION $e)
{
	$e->getMessage();
}

?>



