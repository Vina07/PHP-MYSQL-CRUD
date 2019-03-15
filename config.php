<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('Europe/London'); // You can change this to you time zone

//database credentials
define('DBHOST','localhost');        // This should work if not try ip website address or define path to your database
define('DBUSER','root'); // Database username most often with the database prefix_username if not try username
define('DBPASS','password');        // Database Password
define('DBNAME','lg');   // Database name most often with the database prefix_databasename if not try databasename

//application address
define('DIR','http://www.domain.com/'); //Path the the directory where the forms are stored i.e. http://www.domain.com or http://www.domain.com/subfolder/
define('SITEEMAIL','noreply@domain.com'); // Registered users will receive an email from this address i.e. admin@yourdomain.com

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);
?>
