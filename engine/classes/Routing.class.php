<?php
if(!defined("IN_SYSTEM"))
	die('Direct Access Denied!');
	
class Routing extends Engine 
{

    public function Init()
    {
        if ($_REQUEST['get'])
        {
            $get = trim($_REQUEST['get']);
            $getPage = explode('/', $get);
        } 

        if ($_REQUEST['get'])
        {
            
            if(file_exists(ROOT_DIR."/pages/".$getPage[0].".html"))
            {
                require_once ROOT_DIR."/pages/".$getPage[0].".html";
            }
            elseif(file_exists(ROOT_DIR."/engine/modules/".$getPage[0].".php"))
            {
                require_once(ROOT_DIR."/engine/modules/".$getPage[0].".php");
            }
            else
            {
                require_once(ROOT_DIR."/pages/404.html");
            }
        }
        else
        {
            require_once(ROOT_DIR."/pages/main.html");
        }
    }

}
    
?>