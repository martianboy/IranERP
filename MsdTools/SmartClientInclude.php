<?php
require_once 'config.php';
function GetSmartClientJs()
{
	$rtnval='';
	$isomorphicDir=BasicPath.'isomorphic/';
	
	$rtnval ='<script>var isomorphicDir="'.$isomorphicDir.'";</script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/modules/ISC_History.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/development/ISC_FileLoader.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/modules/ISC_Core.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/modules/ISC_Foundation.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/modules/ISC_Containers.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/development/ISC_Grids.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/modules/ISC_Forms.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/modules/ISC_RichTextEditor.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'system/modules/ISC_DataBinding.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
	$rtnval.='<script type="text/javscript" src='.$isomorphicDir.'skins/Graphite/load_skin.js></SCRIPT>';
	/*$rtnval.='<script>';
	$rtnval.='isc.currentSkin = isc.params.skin;';
	$rtnval.='if (isc.currentSkin == null) isc.currentSkin = "Enterprise";';
	$rtnval.='isc.FileLoader.loadSkin(isc.currentSkin, "showExplorer()");';
	$rtnval.='</script>';
	*/
return $rtnval;
}

?>
