<?php
if(!defined("IN_SYSTEM"))
	die('Direct Access Denied!');
	
class Tpl extends Engine 
{
	public function lolReplace($str1, $str2)
	{
		$Replace = str_ireplace($str1, $str2,$Replace);
		return true;
	}
	
	public function tplHead($pageName = "", $collation = "cp1251") 
	{
		global $oEngine, $Func, $mConfig, $isUser, $Module, $Module_1;
		
		if(empty($pageName))
			$pageName = "{$mConfig['system']['sitename']}";
		else
			$pageName = $pageName . " &#151; {$mConfig['system']['sitename']}";
		
		if(file_exists(TPL_DIR . 'tpl_header.tpl')) 
			require_once(TPL_DIR . 'tpl_header.tpl');
		else 
			$oEngine->error('Error opening header: file \'tpl_header.tpl\' not found');
	}
	
	public function tplFoot($type = "")
	{
		global $oEngine, $isUser, $Func, $Db, $Tpl, $queries, $tstart, $query_stat, $querytime, $linkfeed;
		
        if($type == "")
        {
            if(file_exists(TPL_DIR . 'tpl_footer.tpl')) 
                require_once(TPL_DIR . 'tpl_footer.tpl');
            else 
                $oEngine->error('Error opening footer: file \'tpl_footer.tpl\' not found');
        }
        else
        {
            if(file_exists(TPL_DIR . 'tpl_footer_'.$type.'.tpl')) 
                require_once(TPL_DIR . 'tpl_footer_'.$type.'.tpl');
            else 
                $oEngine->error('Error opening footer: file \'tpl_footer_'.$type.'.tpl\' not found');
        }
        
        
        
        /*if ((isset($_GET["queries"]) || $isUser['name'] == 'rcount') && count($query_stat)) {
            foreach ($query_stat as $key => $value) {
                print("<div>[".($key+1)."] => <b>".($value["seconds"] > 0.01 ? "<font color=\"red\" title=\"Рекомендуется оптимизировать запрос. Время исполнения превышает норму.\">".$value["seconds"]."</font>" : "<font color=\"green\" title=\"Запрос не нуждается в оптимизации. Время исполнения допустимое.\">".$value["seconds"]."</font>" )."</b> [".htmlspecialchars_uni($value['query'])."]</div>\n");
            }
        }*/
	}
	
    /**
     * replace($str1, $str2)
     * замена
     */
    public function replace($str1, $str2)
	{
		//global $tpl_load_time;$s_time=get_real_time();
		if($this->tplGet)
        {
            $this->tplGet = str_ireplace($str1, $str2, $this->tplGet);
            //$tpl_load_time+=get_real_time() - $s_time;
            return true;
        }
		else
		return false;
	}
    
	public function tplGet($tpl,$params=array())
	{
		global $oEngine, $Func, $Db, $isUser, $cache;
		if(file_exists(TPL_DIR."tpl_{$tpl}.tpl"))
        {
            ob_start();
			require_once(TPL_DIR."tpl_{$tpl}.tpl");
            $html = ob_get_clean(); // get buffer contents
        }
		else        
			$oEngine->error('Error opening template: file \'tpl_'.$tpl.'.tpl\' not found');        
   
        foreach ($params as $key=>$value) {
           $html = str_replace('{'.$key.'}', $value, $html);
        }
        
        echo $html;
	}
	
	private function getLeftBlock()
	{
		global $module;
		if($module == '' || $module == 'users')
			require_once(TPL_DIR."tpl_main_leftblock.tpl");
	}
	
	private function getNavbar($str,$link, $navbar)
	{
		if($link)
			$next = "<a href='{$link}' title='{$str}'>{$str}</a>";
		else
			$next = "{$str}";
		if($navbar = true)
			$insert = "$next";
		else 
			$insert = "";
		$echo = '<div class="cNavbar"> 
			<a href="/">Главная</a> <span>&nbsp;</span> '.$insert.'					
			</div>';
			
		return $echo;
	}
	
	public function getStartBlock($str,$link,$navbar)
	{
		//$Navbar = $this->getNavbar($str,$link);
		print('
		<table cellspacing="0" cellpadding="0" width="100%"> 
			<tr> 
				<td style="background:url(/tpl/i/sidebg.gif) repeat-y;" width="8px" > 
				</td> 
				<td align="left" valign="top"> 
					'.$this->getNavbar($str,$link, $navbar).'
					<div class="cBlockTop"> 
						<h1>'.$str.'</h1>
					</div>
				</td> 
			</tr> 
		</table>
		');
	}
}
?>