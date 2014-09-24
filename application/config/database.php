<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'localhost';
$db['default']['username'] = 'root';
$db['default']['password'] = 'Wanghb%pwd%';
$db['default']['database'] = 'test';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

//smzdm db
$db['smzdm']['masterMax'] = 0;  //写最大数
$db['smzdm']['hostname'] = '10.1.1.20';
$db['smzdm']['username'] = 'smzdm';
$db['smzdm']['password'] = 'sMzdmTest';
$db['smzdm']['database'] = 'smzdm';
$db['smzdm']['dbdriver'] = 'mysqli';
$db['smzdm']['dbprefix'] = '';
$db['smzdm']['pconnect'] = FALSE;
$db['smzdm']['db_debug'] = TRUE;
$db['smzdm']['cache_on'] = FALSE;
$db['smzdm']['cachedir'] = '';
$db['smzdm']['char_set'] = 'utf8';
$db['smzdm']['dbcollat'] = 'utf8_general_ci';
$db['smzdm']['swap_pre'] = '';
$db['smzdm']['autoinit'] = TRUE;
$db['smzdm']['stricton'] = FALSE;

//产品库读库
$db['product_read']['masterMax'] = 0;  //写最大数
$db['product_read']['hostname'] = 'db-server_read01_eth01';
$db['product_read']['username'] = 'productAdmin';
$db['product_read']['password'] = 'productTest';
$db['product_read']['database'] = 'product';
$db['product_read']['dbdriver'] = 'mysqli';
$db['product_read']['dbprefix'] = '';
$db['product_read']['pconnect'] = FALSE;
$db['product_read']['db_debug'] = TRUE;
$db['product_read']['cache_on'] = FALSE;
$db['product_read']['cachedir'] = '';
$db['product_read']['char_set'] = 'utf8';
$db['product_read']['dbcollat'] = 'utf8_general_ci';
$db['product_read']['swap_pre'] = '';
$db['product_read']['autoinit'] = TRUE;
$db['product_read']['stricton'] = FALSE;

$db['product_write']['masterMax'] = 0;  //写最大数
$db['product_write']['hostname'] = 'db-server_write01_eth01';
$db['product_write']['username'] = 'productAdmin';
$db['product_write']['password'] = 'productTest';
$db['product_write']['database'] = 'product';
$db['product_write']['dbdriver'] = 'mysqli';
$db['product_write']['dbprefix'] = '';
$db['product_write']['pconnect'] = FALSE;
$db['product_write']['db_debug'] = TRUE;
$db['product_write']['cache_on'] = FALSE;
$db['product_write']['cachedir'] = '';
$db['product_write']['char_set'] = 'utf8';
$db['product_write']['dbcollat'] = 'utf8_general_ci';
$db['product_write']['swap_pre'] = '';
$db['product_write']['autoinit'] = TRUE;
$db['product_write']['stricton'] = FALSE;

/* End of file database.php */
/* Location: ./application/config/database.php */