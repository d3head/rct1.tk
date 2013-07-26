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

?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
<script type="text/javascript" src="/tpl/js/jquery.tipsy.js"></script>
<script type='text/javascript'>
	$(function() {
		$('.tip').tipsy({gravity: 'w'});
	});
</script>
<?

if($_FILES['uploadfile']['size'] > 1024*16*1024)
{
	echo "filesize";
	die();
}

$uploaddir 	= './u/'; 
$mime		= $_FILES['uploadfile']['type'];

$filename	= generate_name(5);
$ext 		= end(explode('.', $_FILES['uploadfile']['name']));
$filesize	= round($_FILES['uploadfile']['size'] / 1024 / 1024, 2);


if($mime == "image/gif" || $mime == "image/jpeg" || $mime == "image/jpg" || $mime == "image/png")
{
	$file 	= $uploaddir . 'i/' . $filename.'.'.$ext;
	$link  .= 'http://<a href="http://rct1.tk/u/i/' . $filename.'.'.$ext . '" title="'.$_FILES['uploadfile']['name'].' ('.$filesize.' MB)" class="tip">rct1.tk/u/i/' . $filename.'.'.$ext . '</a>';
}
else
{
	$file	= $uploaddir . 'a/' . $filename.'.'.$ext;
	$link  .= 'http://<a href="http://rct1.tk/u/a/' . $filename.'.'.$ext . '" title="'.$_FILES['uploadfile']['name'].' ('.$filesize.' MB)" class="tip">rct1.tk/u/a/' . $filename.'.'.$ext . '</a>';
}


if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) 
{ 
	echo $link; 
} 
else 
{
	echo "error";
}