<?php
	define('DB_HOST', 'localhost');
	define('DB_USER', 'main_user');
	define('DB_PASS', '1234');
	define('DB_NAME', 'main_db');

	if (!$db = mysql_connect(DB_HOST,DB_USER,DB_PASS)) {
	    echo 'На жаль не вдалося підключитися до серверу БД.';
	        exit;
	}
	if (!mysql_select_db(DB_NAME)) {
	    echo 'Не вдалося підключити БД.';
	        exit;
	}
    mysql_query("SET CHARSET windows-1251");
?>