<?php
/**
 * Production Database Configuration Template for cPanel
 *
 * In cPanel:
 * 1. Create a MySQL Database (e.g. cpaneluser_spidertech)
 * 2. Create a MySQL User and set a strong password (e.g. cpaneluser_dbuser)
 * 3. Assign the User to the Database with ALL PRIVILEGES
 * 4. Update the values below in config/db_config.php on your server
 */
return [
    'db_host' => 'localhost', // Usually 'localhost' on cPanel
    'db_name' => 'your_cpanel_dbname',
    'db_user' => 'your_cpanel_dbuser',
    'db_pass' => 'your_cpanel_dbpassword'
];
