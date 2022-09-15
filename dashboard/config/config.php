<?php

if (ENVIRONMENT === 'development') {
    define('DB_HOST', 'localhost');
    define('DB_PORT', '3306');
    define('DB_NAME', 'db_flash_food');
    define('DB_USER', 'root');
    define('DB_PASS', '');
} else {
    define('DB_HOST', 'localhost');
    define('DB_PORT', '3306');
    define('DB_NAME', 'db_flash_food');
    define('DB_USER', 'root');
    define('DB_PASS', '');
}
