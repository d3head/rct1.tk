<?php
if(!defined("IN_SYSTEM"))
	die('Direct Access Denied!');
	
function generate_name($number)
{
	$arr = array('a','b','c','d','e','f',
				 'g','h','i','j','k','l',
				 'm','n','o','p','r','s',
				 't','u','v','x','y','z',
				 'A','B','C','D','E','F',
				 'G','H','I','J','K','L',
				 'M','N','O','P','R','S',
				 'T','U','V','X','Y','Z',
				 '1','2','3','4','5','6',
				 '7','8','9','0');
	$name = "";
	for($i = 0; $i < $number; $i++)
	{
	  $index = rand(0, count($arr) - 1);
	  $name .= $arr[$index];
	}
	
	return $name;
}	

$api_url = $Func->moduleName("", false, "api\/url\/add\/");
	
switch($getPage[1])
{
	case 'url':
		switch($getPage[2])
		{		
			case 'add':
			
				$shorturl = generate_name(4);
				
				if($_POST)
				{
					$url = htmlspecialchars($_POST['url']);
					
					if(!preg_match('@^(?:http://)@i', $url))
						$url = 'http://'.$url;
						
					$url = explode('//', $url);
					$url = $url[1];
				}
				elseif($api_url)
				{
					$url = $api_url;
					$url = explode(':/', $url);
					$url = $url[1];
				}
				else
				{
					echo '{
							"status":"fail",
							"message":"Empty URL."
						  }
						';
					exit();
				}
				
				$check = $Db->dbQuery('id, url, shorturl', 'urls', 'url = "'.$url.'" OR shorturl = "'.$url.'"');
				$check = $Db->dbAssoc($check, true);
				if($check)
				{
					echo '{
							"status":"already",
							"message":"http://'.$check['url'].' already exists in database",
							"shorturl":"http://'.$check['shorturl'].'"
						  }
						';
				}
				else
				{
					$Db->dbInsert('urls', 'url, shorturl, added', '"'.$url.'", "rct1.tk/'.$shorturl.'", "'.$Func->fGetDateTime().'"');
					
					echo '{
							"status":"ok",
							"message":"http://'.$url.' added to database",
							"shorturl":"http://rct1.tk/'.$shorturl.'"
						  }
						';
				}
				
			break;
			
			case 'stats':
			
			break;
			
			default:
				header("Location: /");
		}
	break;
	
	default:
		header("Location: /");
}