<?php
/* Data base details */
$dsn='mysql:host=localhost;dbname=joomla'; //DSN
$db_user='root'; //DB username
$db_pass=''; //DB password    
$driver='Joomla'; //Integration driver
$db_prefix='zdl4b_'; //prefix used for tables in database
$uid='5988c2e945c7e'; //Any random unique number

$PATH = 'freichat/'; // Use this only if you have placed the freichat folder somewhere else
$installed=false; //make it false if you want to reinstall freichat
$admin_pswd='12345'; //backend password 

$debug = false;
$custom_error_handling='NO'; // used during custom installation

$use_cookie=false;

/* email plugin */
$smtp_username = '';
$smtp_password = '';

$force_load_jquery = 'NO';
$force_use_https = 'NO';

/* Custom driver */
$usertable='login'; //specifies the name of the table in which your user information is stored.
$row_username='root'; //specifies the name of the field in which the user's name/display name is stored.
$row_userid='loginid'; //specifies the name of the field in which the user's id is stored (usually id or userid)
$avatar_field_name = 'avatar';
