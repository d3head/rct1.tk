<?php
if(!defined("IN_SYSTEM"))
	die('Direct Access Denied!');
    
switch ($mConfig['system']['cache_type']) {
	case 'XCache':
		$cache = new cache_xcache();
		break;
	case 'eAccelerator':
		$cache = new cache_eaccelerator();
		break;
	default:
		$cache = new cache_common();
}

class cache_common {
	var $used = false;
	/**
	* Returns value of variable
	*/
	function get($name) {
		return false;
	}
	/**
	* Store value of variable
	*/
	function set($name, $value, $ttl = 0) {
		return false;
	}
	/**
	* Remove variable
	*/
	function rm($name) {
		return false;
	}
}

class cache_xcache extends cache_common {
    var $used = true;

    function cache_xcache() {
        if (!$this->is_installed()) {
            die('Error: XCache extension not installed');
        }
    }

    function get($name) {
        return unserialize(xcache_get($name));
    }

    function set($name, $value, $ttl = 0) {
        return xcache_set($name, serialize($value), $ttl);
    }

    function exists($name) {
        return (bool) xcache_isset($name) && $_GET["no_cache"] != 1 && !defined('NO_CACHE');
    }

    function rm($name) {
        return xcache_unset($name);
    }

    function is_installed() {
        return function_exists('xcache_get');
    }
}

class cache_eaccelerator extends cache_common {
    var $used = true;

    function cache_eaccelerator() {
        if (!$this->is_installed()) {
            die('Error: eAccelerator extension not installed');
        }
    }

    function get($name) {
        return unserialize(eaccelerator_get($name));
    }

    function set($name, $value, $ttl = 0) {
        return eaccelerator_put($name, serialize($value), $ttl);
    }

    function exists($name) {
        return eaccelerator_get($name) && $_GET["no_cache"] != 1 && !defined('NO_CACHE');
    }

    function rm($name) {
        return eaccelerator_rm($name);
    }

    function is_installed() {
        return function_exists('eaccelerator_get');
    }
}
?>