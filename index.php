<?php
//
define('IN_SYSTEM',true);

require_once(dirname(__FILE__).'/engine/config.php');
require_once(ROOT_DIR.'/engine/classes/Engine.class.php');

$oEngine = Engine::getInstance();
$tstart = $oEngine->timer();
$Func = new Functions;
$Db = new Db;
$Tpl = new Tpl;

$Db->dbConnect();
$Func->userLogin();

if ($_REQUEST['get'])
{
    $get = trim($_REQUEST['get']);
    $getPage = explode('/', $get);
} 

if ($_REQUEST['get'])
{
    
    if(file_exists(ROOT_DIR."/pages/".$getPage[0].".html"))
    {
		$Module = $getPage[0];
        require_once ROOT_DIR."/pages/".$getPage[0].".html";
    }
    elseif(file_exists(ROOT_DIR."/engine/modules/".$getPage[0].".php"))
    {
		$Module = $getPage[0];
        require_once(ROOT_DIR."/engine/modules/".$getPage[0].".php");
    }
	elseif(file_exists(ROOT_DIR."/engine/modules/urls.php"))
    {
		$Module = 'urls';
        require_once(ROOT_DIR."/engine/modules/urls.php");
    }
    else
    {
		$Module = '404';
        require_once(ROOT_DIR."/pages/404.html");
    }
}
else
{
	$Module = 'main';
    require_once(ROOT_DIR."/pages/main.html");
}

$oEngine->Unload();