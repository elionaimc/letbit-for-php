<?php
/**
 * Definitions for self knowing of structure
 */
define('DS', DIRECTORY_SEPARATOR);// Shortcut for system directory separator
define('ROOT', dirname(__FILE__));// Root directory shortcut
define('APP', 'app'.DS.'main');// App/Main directory shortcut
define('MODULES', 'app'.DS.'modules');// Modules directory shortcut

/**
 * Let blank if you are executing the project since the root folder of de host
 * (e.g. 'www' ou 'httpdocs');
 * Double attention needed if you use case-sensitive server rules
 */
define('URL_BASE', '');

/**
 * Turn it FALSE if you dont want to treat and show routes errors
 * defeult = TRUE
 */
define('SHOW_ROUTE_ERRORS', false);
define('LOGGED_IN', 1800);// Limit time for logged in seconds (1800 = 30 min)

/**
 * Definitions about your project
 * Some of this info will be apear into the header of the project pages
*/
define('AUTHOR', '');// It means YOU!
define('TITLE', '');// General <title> content for the project!
define('CATEGORY', '');// General category of the project!
define('DESCRIPTION', '');// Description of content
define('KEYWORDS', '');// Keywords of content
define('LANGUAGE', 'en-US');// Defines @LANG property on <html> tag

/**
 * Definitions about the database conection
*/
define('HOST', 'localhost');// Database host
define('PORT', '');// Database conection port: let blank for default, 3306 = MySQL; 5432 = PostgreSQL
define('DBUSER', '');// Database username
define('DBPASS', '');// Database password
define('DBNAME', '');// Database name
define('DBUTF8', true);// Database encoding, set false for default encoding in connection
define('DBPREFIX', 'mysql');// Database conection prefix: mysql, pgsql, sqlsrv etc
