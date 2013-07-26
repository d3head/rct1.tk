<?php
if(!defined("IN_SYSTEM"))
	die('Direct Access Denied!');
    
define('ROOT_DIR', dirname(dirname(__FILE__)) . '/');
define('LIBS_DIR', dirname(dirname(__FILE__)) . '/engine/libs/');
define('TPL_DIR', dirname(dirname(__FILE__)) . '/tpl/');
define('PATH', 'http://'.$_SERVER['SERVER_NAME'].'/');
define('USE_GZ', TRUE); // Использовать сжатие GZ?
define('USE_CACHE', FALSE); // Использовать кэш?
define('USE_MYSQL', TRUE); // Использовать базу данных MySQL?

// Системные настройки
$mConfig['db']['connect']['host']	=	"_"; // Хост к базе данных
$mConfig['db']['connect']['user']	=	"_"; // Пользователь к базы данных
$mConfig['db']['connect']['pass']	=	"_"; // Пароль к базе данных
$mConfig['db']['connect']['name']	=	"_"; // Название базы данных
$mConfig['db']['connect']['char']	=	"utf8"; // Кодировка базы данных
$mConfig['system']['sitename']  	=	"_"; // Название сайта
$mConfig['system']['version']       =   '0.0.2'; // Версия ядра
$mConfig['system']['cache_type']    =   'XCache'; // Тип используемого кэша

// Настройки шаблона
$mConfig['meta']['keywords']	    =	"файлы, картинки, хостинг"; // META Ключевые слова
$mConfig['meta']['description'] 	=	""; // META описание
$mConfig['tpl']['speedbar']			=	false; // Показывать спидбар в шаблоне?
?>