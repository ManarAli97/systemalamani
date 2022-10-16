<?php

// 192.168.9.82 localhost
 define('url', 'http://127.0.0.1/systemalamani');
//  define('url', 'http://192.168.31.92/localalamni');



define('URL_DOWNLOAD', 'https://in.alamani.iq/public/ar/save_file/');



define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('COT', 'controllers');
define('FILES', url . "/public/save_file/");
define('ROOT_FILES', ROOT . "/public/save_file/");
define('FILES_h27',url."/public/ar/save_file/");
define('ROOT_FILES_h27',ROOT."/public/ar/save_file/");
define('IMAGE', 'default.png');
define('TAG', '<h1><h2><h3><h4><h5><h6><strong><br><i><strike><u><font><big><small><blockquote><ul><li><ol><del><em><div><sub><sup><table><tr><td><tbody><thead><th><a><img><hr><style><span><p>');


//Always provide a TRAILING SLASH (/) AFTER A PATH

define('LIBS', 'libs/');

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'alamani');
define('DB_USER', 'root');
define('DB_PASS', '');
//define('DB_PASS','QGtGI{lY{{UF');
define('CHAR_SET', 'SET NAMES utf8');

//this sitewide hashkey  do not change this because its used for password
//this is for other hash keys
define('HASH_GENERAL_KEY', 'ali');
//this is for database password only
define('HASH_PASSWORD_KEY', 'ali');


/**
* Haider add this field to confing the API with NAS
*/

define('python_Path', 'C:\\Python37\\python.exe');
define('localPath','C:\\xampp\\htdocs\\localalamni\\controllers\\');
define('NAS_url', 'https://edu-myoffice-inc68.odoo.com');
define('NAS_db', 'edu-myoffice-inc68');
define('NAS_username', 'a189@alamani.iq');
define('NAS_password', '7drvV*P_5XkH!kz');
define('NAS_connction', NAS_url.' '.NAS_db.' '.NAS_username.' '.NAS_password);

