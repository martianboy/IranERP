<?php
require_once 'config.php';
function GetSmartClientJs()
{
	$rtnval='';
	$isomorphicDir=BasicPath.'isomorphic/';
	
	$rtnval ='<SCRIPT>var isomorphicDir="'.$isomorphicDir.'";</SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/modules/ISC_History.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/development/ISC_FileLoader.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/modules/ISC_Core.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/modules/ISC_Foundation.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/modules/ISC_Containers.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/development/ISC_Grids.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/modules/ISC_Forms.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/modules/ISC_RichTextEditor.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'system/modules/ISC_DataBinding.js?isc_version=SC_SNAPSHOT-2011-01-06.js></SCRIPT>';
	$rtnval.='<SCRIPT SRC='.$isomorphicDir.'skins/Graphite/load_skin.js></SCRIPT>';
	/*$rtnval.='<script>';
	$rtnval.='isc.currentSkin = isc.params.skin;';
	$rtnval.='if (isc.currentSkin == null) isc.currentSkin = "Enterprise";';
	$rtnval.='isc.FileLoader.loadSkin(isc.currentSkin, "showExplorer()");';
	$rtnval.='</script>';
	*/
return $rtnval;
}


?>
