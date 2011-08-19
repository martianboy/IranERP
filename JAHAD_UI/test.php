<?php
define('dsMaster','Matter');

$dataSources=array(dsMaster=>array('ClassName'=>'Matter','Title'=>'موضوعاتا'));
$Perfix='_';

//Set Page Content Charset
header('Content-Type: text/html;charset=utf-8');

$currentFile = 'test';

//Detect Operation 
$optype =Common::GetVar($Perfix.'operationType');
switch($optype){
    case 'fetch':
	    PageResponser::fetchResponse($dataSources[dsMaster]['ClassName'], $em);
	    break;
    case 'add':
	    //Get Class Instance
	    PageResponser::AddRecord($dataSources[dsMaster]['ClassName'], $em);
	    break;
    case 'update':
	    PageResponser::UpdateRecord($dataSources[dsMaster]['ClassName'], $em);
	    break;
    case 'remove':
	    PageResponser::RemoveRecord($dataSources[dsMaster]['ClassName'], $em);
	    break;
}
?>
<?php 
/**
 * Set Template Variables
 * 
 */
$smarty->assign('SmartClientJs',GetSmartClientJs());
$smarty->assign('dsMaster',dsMaster);
$smarty->assign('currentFile',$currentFile);
?>
<?php 
if($optype != null) 
	die;
else {
    $tpl=Common::GetVar('tpl');
    if($tpl==null) $tpl=$currentFile;
    $tpl=$currentFile.'/'.$tpl;
    $smarty->display($tpl.'.html');
}
?>
