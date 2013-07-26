<?php
define('IN_SYSTEM',true);

if($isUser['class'] < 2)
    header("Location: /");
	
$Module_name = 'Админ-панель';

$amodule = $getPage[1];

if($amodule)
{
    if(file_exists(ROOT_DIR."/engine/modules/admincp/".$amodule.".php"))
    {
        require_once ROOT_DIR."/engine/modules/admincp/".$amodule.".php";
    }
    else
    {
        require_once(ROOT_DIR."/pages/404.html");
    }
}
else
{
    require_once(ROOT_DIR."/engine/modules/admincp/admin.php");
}
?>