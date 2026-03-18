<?php
    require('connect.php');
    
    session_start();

    if(!isset($admin_id)){
        header('location:../admin/admin_login.php');
    }