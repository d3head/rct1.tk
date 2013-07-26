<?php
if(!defined("IN_SYSTEM"))
	die('Direct Access Denied!');

function __autoload($class)
{
    if(isset($class))
    {
        if($class != 'finfo')
        {
            if(file_exists(ROOT_DIR.'/engine/classes/'.$class.'.class.php'))     
                require_once(ROOT_DIR.'/engine/classes/'.$class.'.class.php');
            else
                Engine::getInstance()->error('Class "'.$class.'" required, but not found');
        }
    }
}

if(USE_CACHE)
{
    require_once(ROOT_DIR.'/engine/classes/cache.class.php');
}

class Engine 
{
	public $oEngine = null;
    static protected $oInstance = NULL;
    
    function __construct() {
		static $already_loaded;
        if (extension_loaded('zlib') && ini_get('zlib.output_compression') != '1' && ini_get('output_handler') != 'ob_gzhandler' && USE_GZ && !$already_loaded) {
            @ob_start('ob_gzhandler');
        } elseif (!$already_loaded)
            @ob_start();
        $already_loaded = true;
	}
	
	public function error($info=NULL,$level=E_ALL) 
    {
		switch($level) {
			case E_ERROR:
			case E_ALL:
			case E_WARNING:
				die($info);
			break;
		}
		die($info);
	}
    
    static public function getInstance() {
		if (isset(self::$oInstance) and (self::$oInstance instanceof self)) {
			return self::$oInstance;
		} else {
			self::$oInstance = new self();
			return(self::$oInstance);
		}
	}
    
    public function Unload() {
		@ob_end_flush();
	}
    
    public function timer() 
    {
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

}	
?>