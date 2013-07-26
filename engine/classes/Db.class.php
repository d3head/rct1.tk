<?php
if(!defined("IN_SYSTEM"))
	die('Direct Access Denied!');
	
class Db extends Engine {

	public function dbConnect() {
		global $mConfig, $oEngine;
        if(USE_MYSQL)
        {
            $db_name = $mConfig['db']['connect']['name'];
            $db_host = $mConfig['db']['connect']['host'];
            $db_user = $mConfig['db']['connect']['user'];
            $db_pass = $mConfig['db']['connect']['pass'];
            $db_char = $mConfig['db']['connect']['char'];
            if(mysql_connect($db_host, $db_user, $db_pass)) {
                mysql_query("SET NAMES ".$db_char);
                if(mysql_select_db($db_name)) {
                    return($this);
                } else {
                    $oEngine->error('Error selecting database: '.mysql_error(),E_ERROR);
                    return(false);
                }
            } else {
                $oEngine->error('Error connecting to database: '.mysql_error(),E_ERROR);
                return(false);
            }	
            
            register_shutdown_function("autoclean");   
            register_shutdown_function("mysql_close");
        }
	}
	
	public function dbArray($rowSet) {
		return(mysql_fetch_array($rowSet));
	}
	
	public function dbRow($rowSet) {
		return(mysql_fetch_row($rowSet));
	}
	
	public function dbAssoci($rowSet) {
		return(mysql_fetch_assoc($rowSet));
	}
    
    public function dbFreeResult($rowSet) {
		return(mysql_free_result($rowSet));
	}
	
	public function dbAssoc($rowSet, $singleRow=false) {
		$resultArray = array();
		while($row = mysql_fetch_assoc($rowSet)) 
		{
			array_push($resultArray, $row);
		}
		if($singleRow === true)
			return $resultArray[0];
		return($resultArray);
	}
	
	public function dbNumRows($rowSet) {
		return(mysql_num_rows($rowSet));
	}
	
	public function dbQuery($what, $table, $where="") {
		global $oEngine, $queries, $query_stat, $querytime;
        
		$queries++;

		if($where) {
			$sql = "SELECT $what FROM $table WHERE $where";
		} else {
			$sql = "SELECT $what FROM $table";
		}
        
        $query_start_time = $oEngine->timer(); 
		$result = mysql_query($sql) or $oEngine->error('Error selecting from database: '.mysql_error(),E_ERROR);    
        $query_end_time = $oEngine->timer(); // End time
        
        $query_time = ($query_end_time - $query_start_time);
        $query_stat_time = ($query_time * 100);
        $querytime = $querytime + $query_time;
        $query_stat[] = array("seconds" => $query_stat_time, "query" => $sql);
		//if(mysql_num_rows($result) == 1)
			//return $this->dbRowSet($result, true);
		//return $this->dbRowSet($result);
		return($result);
	}
	
	public function dbInsert($table, $set, $value) {
		global $oEngine;
		
		$sql = "INSERT INTO $table ($set) VALUES ($value)";
		
		$result = mysql_query($sql) or $oEngine->error('Error inserting into database: '.mysql_error(),E_ERROR);
		return;
	}
	
	public function dbUpdate($table, $set, $where="") {
		global $oEngine;
		
		if($where) {
			$sql = "UPDATE $table SET $set WHERE $where";
		} else {
			$sql = "UPDATE $table SET $set";
		}
		
		$result = mysql_query($sql) or $oEngine->error('Error updating to database: '.mysql_error(),E_ERROR);
		return;
	}
	
	public function dbDelete($table, $where="") {
		global $oEngine;
		
		if($where) {
			$sql = "DELETE FROM $table WHERE $where";
		} else {
			$sql = "DELETE FROM $table";
		}
		$result = mysql_query($sql) or $oEngine->error('Error deleting from database: '.mysql_error(),E_ERROR);
		return;
	}
	
	public function dbCount($table, $suffix="") {
		global $oEngine;
		$r = mysql_query("SELECT COUNT(*) FROM $table $suffix") or $oEngine->error('Error selecting from database: '.mysql_error(),E_ERROR);
		$a = mysql_fetch_row($r) or $oEngine->error('Error selecting from database: '.mysql_error(),E_ERROR);
		return($a[0]);
	}

}
?>