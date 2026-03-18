<?php
	session_start();
	$spider_tech_db = mysqli_connect('localhost', 'root', '', 'spider_tech_updated_db');
    if($spider_tech_db->connect_errno > 0){ die('Unable to connect to the database'); }
?>