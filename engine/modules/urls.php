<?php
if(!defined("IN_SYSTEM"))
	die('Direct Access Denied!');
	
$url = 'rct1.tk/'.$getPage[0];

$check = $Db->dbQuery('id, url, shorturl', 'urls', 'shorturl = "'.$url.'"');
$check = $Db->dbAssoc($check, true);
if($check)
{
	$Db->dbUpdate('urls', 'clicks = clicks + 1', 'id = '.$check['id'].'');
	header("Location: http://{$check['url']}");
}
else
{
	header("Location: /");
}