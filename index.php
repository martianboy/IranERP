<?php
error_reporting(0);
require_once 'MsdTools/RestDataSource.php';
require_once 'MsdTools/SmartClientInclude.php';
require_once 'DefineClasses.php';
require_once 'bootstrap.php';
require_once 'Smarty/libs/Smarty.class.php';
require_once 'MsdTools/WhereMaker.php';

function GetVar($VarName)
{
//Get From Query String
$rtnval=null;
	try{
		$query = explode('?',$_SERVER['QUERY_STRING']);
		$tmpvar = explode('&',$query[0]);
		
		$Variable = array();
		foreach($tmpvar as $v){
			$tmp= explode('=',$v);
			if(array_key_exists($tmp[0],$Variable))
			{
				if(is_array($Variable[$tmp[0]])) $Variable[$tmp[0]][]=$tmp[1];
				else
				{
					$oldvalue=$Variable[$tmp[0]];
					$Variable[$tmp[0]]=array();
					$Variable[$tmp[0]][]=$oldvalue;
					$Variable[$tmp[0]][]=urldecode($tmp[1]);
				}
			}
			else
			$Variable[$tmp[0]]=urldecode($tmp[1]);
		}
		
		$rtnval=$Variable[$VarName];
		
	}catch(Exception $e)
	{
		print_r($e);
	}
	if($rtnval==null){
	$rtnval = $_GET[$VarName];
	if($rtnval != null) return $rtnval;
	$rtnval = $_POST[$VarName];
	}
	//if($VarName=='criteria') print_r($rtnval);
	//print_r($_SERVER['QUERY_STRING']);
	//print_r($Variable);
	return $rtnval;
}

$smarty = new Smarty();
//Get Page To Redirect To From URL
$phpfile ='JAHAD_UI/'. $_GET['phpmodule'].'.php';
require $phpfile;
?>