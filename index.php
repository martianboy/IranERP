<?php
error_reporting(0);
require_once 'MsdTools/RestDataSource.php';
require_once 'MsdTools/SmartClientInclude.php';
require_once 'DefineClasses.php';
require_once 'bootstrap.php';
require_once 'Smarty/libs/Smarty.class.php';
require_once 'MsdTools/WhereMaker.php';
require_once 'MsdTools/Common.php';
require_once 'MsdTools/PageResponser.php';
$smarty = new Smarty();
//Get Page To Redirect To From URL
$phpfile ='JAHAD_UI/'. $_GET['phpmodule'].'.php';
require $phpfile;
?>
