<?php
class Functions extends Engine {
    
    // самозапускающаяся функция
	function __construct()
	{
    
    }
    
	public function fError($text) {
		print("<b>{$text}</b>");
		return;
	}
	
	public function fFatal($text) {
		die("The kernel has been stopped:<br /><b>{$text}</b>");
		return;
	}
	
	public function fNError($text) {
		global $Tpl;
		$Tpl->tplHead('Ошибка');
		print("       
        <div class='block'>
        <div class='blocktitle'>Ошибка</div>
        {$text}
        </div>
        ");
		$Tpl->tplFoot();
		die();
		return;
	}
	
	public function fGetDateTime($timestamp = 0) {
	if ($timestamp)
		return(date("Y-m-d H:i:s", $timestamp));
	else
		return(date("Y-m-d H:i:s"));
	}
	
	public function fNormalDate($date="", $time = false) {
		if(!empty($date))
			$date = $date;
		else
			$date = $this->fGetDateTime();
		$search = array('January','February','March','April','May','June','July','August','September','October','November','December');
		$replace = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
		$seconds = strtotime($date);
		if ($time == true)
			$data = date("j F Y в H:i:s", $seconds);
		else
			$data = date("j F Y", $seconds);
		$data = str_replace($search, $replace, $data);
		return $data;
	}
	
	public function fPages($rpp, $count, $href, $opts = array()) {
		$pages = ceil($count / $rpp);

		if (!$opts["lastpagedefault"])
			$pagedefault = 0;
		else {
			$pagedefault = floor(($count - 1) / $rpp);
			if ($pagedefault < 0)
				$pagedefault = 0;
		}

		if (isset($_GET['page'])) {
			$page = 0 + $_GET['page'];
			if ($page < 0)
				$page = $pagedefault;
		}
		else
			$page = $pagedefault;

		   $pager = "<td style='color:#a84e13;font-size:0.9em;'>Страницы: &nbsp;</td>";

		$mp = $pages - 1;
		$as = "&larr;";
		if ($page >= 1) {
			$pager .= "<td>";
			$pager .= "<a href='{$href}" . ($page - 1) . "' class='pageHref'>$as</a>";
			$pager .= "</td><td>&nbsp;</td>";
		}

		$as = "&rarr;";
		if ($page < $mp && $mp >= 0) {
			$pager2 .= "<td>";
			$pager2 .= "<a href='{$href}" . ($page + 1) . "' class='pageHref'>$as</a>";
			$pager2 .= "</td>$bregs";
		}else	 $pager2 .= $bregs;

		if ($count) {
			$pagerarr = array();
			$dotted = 0;
			$dotspace = 3;
			$dotend = $pages - $dotspace;
			$curdotend = $page - $dotspace;
			$curdotstart = $page + $dotspace;
			for ($i = 0; $i < $pages; $i++) {
				if (($i >= $dotspace && $i <= $curdotend) || ($i >= $curdotstart && $i < $dotend)) {
					if (!$dotted)
					   $pagerarr[] = "<td>...</td><td class='pagebr'>&nbsp;</td>";
					$dotted = 1;
					continue;
				}
				$dotted = 0;
				$start = $i * $rpp + 1;
				$end = $start + $rpp - 1;
				if ($end > $count)
					$end = $count;

				 $text = $i+1;
				if ($i != $page)
					$pagerarr[] = "<td><a title='$start&nbsp;-&nbsp;$end' href='{$href}$i' style='font-size:0.9em;'><b>$text</b></a></td><td>&nbsp;</td>";
				else
					$pagerarr[] = "<td style='font-size:0.9em;'><b>$text</b></td><td class='pagebr'>&nbsp;</td>";

					  }
			$pagerstr = join("", $pagerarr);
			$pagertop = "<table align='left'><tr>$pager $pagerstr $pager2</tr></table>\n";
			$pagerbottom = "<table align='left'><tr>$pager $pagerstr $pager2</tr></table>\n";
		}
		else {
			$pagertop = $pager;
			$pagerbottom = $pagertop;
		}

		$start = $page * $rpp;

		return array($pagertop, $pagerbottom, "LIMIT $start,$rpp");
	}
	
	/**
	 * Image_resize($mime, $source, $dest, $max_width, $max_height)
	 * Изменение размера картинки
	 */
	public function Image_resize($mime, $source, $dest, $max_width, $max_height) {
		$newwidth = $max_width;
		$newheight = $max_height;
		list($width, $height) = getimagesize($source);
		if($width <= $newwidth&&$height<=$newheight)
		{$newheight=$height; $newwidth=$width;}
		else {
		if($width > $newwidth)
		{$m=$newwidth / $width;$newheight=$height*$m;}
		else
		{$newwight=$wight;}
		if($newheight > $max_height)
		{$m=$newheight / $max_height; $newheight=$max_height; $newwidth=$newwidth*$m;}
		}
			if(empty($mime))
			{
				$im = getimagesize($source);
				$mime = $im['mime'];		
			}
			switch($mime)
			{
				case 'image/jpeg':
				$source = @imagecreatefromjpeg($source);
				break;
				case 'image/gif';
				$source = @imagecreatefromgif($source);
				break;
				case 'image/png':
				$source = @imagecreatefrompng($source);
				break;
				default:
					return(false);
				break;
			}
			if(!$source)
				return(false);
			$thumb = imagecreatetruecolor($newwidth,$newheight);
			imagealphablending($thumb, false);
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			switch($mime)
			{
				case 'image/jpeg':
					if(@imagejpeg($thumb, $dest, 100))
						return(true);
					else
						return(false);
				break;
				case 'image/gif':
					if(@imagegif($thumb, $dest))
						return(true);
					else
						return(false);
				break;
				case 'image/png':
					if(@imagepng($thumb, $dest, 0))
						return(true);
					else
						return(false);
				break;
			}				
	}
	
	/**
	 * Unesc($x)
	 * Экранирование переменных
	 * @param var x - переменная для экранирования
	 * @return string
	 */
	public function Unesc($x) {
		if (get_magic_quotes_gpc())
			return stripslashes($x);
		return $x;
	}
	
	/**
	 * Quote_smart($value)
	 * Экранирование переменных
	 * @param var value - переменная для экранирования
	 * @return string
	 */
	public function Quote_smart($value) {
		if(get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		if(!is_numeric($value)) {
			$value = mysql_real_escape_string($value);
		}
		return $value;
	}
    
    
    public function  is_online($address = 'mc.nordost.su', $port = 25566) {
        if ($fp = @fsockopen($address, $port, $errno, $errstr, 0.5)){
           fclose($fp);
           return true;
        } else {
           return false;
        }
    }
    
    /**
     * Переводит символы из кириллицы в латиницу
     */
    public function get_chpu($name)
    {
        $name = strtolower($name);
        $r = array(' ','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ь','ы','ъ','э','ю','я');
        $a = array('-','a','b','v','g','d','e','e','zh','z','i','i','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sh','','i','','e','yu','ya');
        $name = str_ireplace($r,$a,$name);
        
        return $name;
    }
    
    
    /*public function links2pages($table, $count, $where = '', $link = '', $glue = ', ')
    {
        global $Db;
        if($link == '') $link = PATH.$_REQUEST['path'].'?';
        // Количество страниц
        $result = $Db->dbQuery("*", "{$table}", "{$where}");
        $pages = ceil($Db->dbNumRows($result) / $count);
        $Db->dbFreeResult($result);
        
        $links = array();

        // Текущая страница
        $current = $_REQUEST['page'] + 1;
        
        if(($current - 3) <= 1) $start = 1;
        else{
            $start = ($current - 3);
            $links[] = "<a href='".$link."page=".($current - 2)."'>&laquo; назад</a>";
        }
        
        if(($current + 3) > $pages) $stop = $pages;
        else $stop = ($current + 3);
        
        for($i = $start; $i <= $stop; $i ++){
            if($i == $current) $links[] = $i;
            else $links[] = "<a href='".$link."page=".($i - 1)."'>".$i."</a>";
        }
        
        if(($current + 3) < $pages) $links[] = "<a href='".$link."page=".($current)."'>вперёд &raquo;</a>";
        
        return implode($glue, $links);
    }*/
    
    public function takeSkinHead($user) 
    {
        if(file_exists(ROOT_DIR."/Minecraft/Skins/".$user.".png"))
        {
            $src = imagecreatefrompng(ROOT_DIR."/Minecraft/Skins/".$user.".png");
        }
        else
        {
            $src = imagecreatefrompng(ROOT_DIR."/Minecraft/Skins/char.png");
        }
        $dest = imagecreatetruecolor(8, 8);
        imagecopy($dest, $src, 0, 0, 8, 8, 80, 40);
        header('Content-Type: image/png');
        imagepng($dest);


        imagedestroy($dest);
        imagedestroy($src);
    }
    
    public function userLogin()
    {
        global $cache, $Db;
        $c_id = intval($_COOKIE['uid']);
        if($c_id)
        {
            /*if ($cache->exists('userdata_'.$c_id))
            {
                $urow = $cache->get('userdata_'.$c_id);          
            }
            else
            {*/
                $urow = $Db->dbArray($Db->dbQuery("*","`authorize_users`","`id` = $c_id"));
                //$cache->set('userdata_'.$c_id, $urow, 300);
            //}
            $GLOBALS['isUser'] = $urow;
            
            if($Db->dbArray($Db->dbQuery("`name`","`banlist`","`name` = '{$urow[name]}'")))
                $this->fNError("Ваш игровой аккаунт отключен.");
            
        }
    }
    
    public function gotoUser($user)
    {
        $link = "<a href='/users/profile/{$user}'>{$user}</a>";
        return $link;
    }
    
    public function addtags($addtags, $from = 'news') 
    {
        foreach(explode(",", $addtags) as $tag)
            $tags .= "<a href=\"/$from/tag/$tag\">$tag</a>, ";
        if ($tags)
            $tags = substr($tags, 0, -2);
        if (empty($addtags))
                $tags = "—";
        return $tags;
    }
	
	public function speedbar()
	{
		global $mConfig, $Module, $Module_name, $Module_1, $Module_1_name;
		
		//$m[] = array();
		if($Module)
			$m = "<a href='/$Module/' title='$Module_name'>$Module_name</a>";
		if($Module_1)
			$m1 = "&rarr; <a href='/$Module/$Module_1/' title='$Module_1_name'>$Module_1_name</a>";
		
		$construct = '<small style="padding-bottom:2px;">Вы здесь: <a href="/" title="Главная">Главная</a> &rarr; '.$m.' '.$m1.'</small>';
		
		if($mConfig['tpl']['speedbar'])
			return $construct;
		else
			return false;		
	}
	
	public function jAlert($header, $text, $out = 'in', $theme = 'black', $sticky)
	{
		if($header)
			$header = ", header: '{$header}'";
		else
			$header = "";
			
		if($sticky)
			$sticky = ", sticky: {$sticky}";
		
		$script = "$.jGrowl('{$text}', { theme: '{$theme}'{$header}{$sticky} });";
		
		if($out == 'in')
			$return = $script;
		elseif($out == 'out')
			$return = "
			<script language='javascript' type='text/javascript'>\n
				{$script}\n
			</script>\n
			";
			
		echo $return;
	}
	
	public function to_json(array $data)
	{
		$isArray = true;
		$keys = array_keys($data);
		$prevKey = -1;

		// Необходимо понять — перед нами список или ассоциативный массив.
		foreach ($keys as $key)
			if (!is_numeric($key) || $prevKey + 1 != $key)
			{
				$isArray = false;
				break;
			}
			else
				$prevKey++;

		unset($keys);
		$items = array();

		foreach ($data as $key => $value)
		{
			$item = (!$isArray ? "\"$key\":" : '');

			if (is_array($value))
				$item .= to_json($value);
			elseif (is_null($value))
				$item .= 'null';
			elseif (is_bool($value))
				$item .= $value ? 'true' : 'false';
			elseif (is_string($value))
				$item .= '"' . preg_replace(
					'%([\\x00-\\x1f\\x22\\x5c])%e',
					'sprintf("\\\\u%04X", ord("$1"))',
					$value
				) . '"';
			elseif (is_numeric($value))
				$item .= $value;
			else
				throw new Exception('Wrong argument.');

			$items[] = $item;
		}

		return
			($isArray ? '[' : '{') .
			implode(',', $items) .
			($isArray ? ']' : '}');
	}
        
	public function moduleName($Var, $Devide = true, $ignoreWords = '')
	{
		if(empty($Devide))
		{
			$moduleName = preg_replace("/" . $ignoreWords . "(.*?)/", "\\1", $_GET['get']);
			return $moduleName;
		}
		else
		{
			$moduleName = explode('/', $_GET['get']);
			return $moduleName[$Var];
		}
	}
}
?>