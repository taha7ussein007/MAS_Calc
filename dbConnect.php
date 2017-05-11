<?php
define("DB_HOST", 'localhost');
define("DB_USER", 'root');
define("DB_PASSWORD", '');
define("DB_DATABSE", 'mas');
        
$conn = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_select_db(DB_DATABSE, $conn);
if(!$conn)// testing the connection
{
    die ("Cannot connect to the database!");
}