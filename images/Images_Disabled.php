<?php
error_reporting(0);
include 'MsdTools/config.php';
function GetVar($VarName)
{
	/*
	 * Test Region
	 *//*
	switch($VarName)
	{
		case '_dataSource':
			return 'Matter';
			break;
		case '_operationType':
			return 'fetch';
			break;
	}*/
	$rtnval = $_GET[$VarName];
	if($rtnval != null) return $rtnval;
	$rtnval = $_POST[$VarName];
	return $rtnval;
}

$IconType = GetVar('IconType');
$ActionType=GetVar('ActionType');
$Color = GetVar('Color');

try{
$filename= ''.$IconType.'/'.$Color.'/'.$ActionType.'.png';
//echo $filename;
header('content-type: image/png');
echo file_get_contents($filename);
}catch (Exception $e)
{
echo $e->getMessage();
}


?>
