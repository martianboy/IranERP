<?php
class MainLayoutHelpers extends CComponent
{
	public static function GetSmartClientJs()
	{
		$resources = array();
		$BasicPath = Yii::app()->baseUrl;
		$isomorphicDir=$BasicPath.'/isomorphic/';
		
		$resources[] = '<script type="text/javascript">var isomorphicDir="'.$isomorphicDir.'";</script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/modules/ISC_History.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/development/ISC_FileLoader.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/modules/ISC_Core.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/modules/ISC_Foundation.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/modules/ISC_Containers.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/development/ISC_Grids.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/modules/ISC_Forms.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/modules/ISC_RichTextEditor.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'system/modules/ISC_DataBinding.js?isc_version=SC_SNAPSHOT-2011-01-06.js></script>';
		$resources[] = '<script type="text/javascript" src='.$isomorphicDir.'skins/Graphite/load_skin.js></script>';
		$resources[] = '<script type="text/javascript" src='.$BasicPath.'/js/GeneralFuncs.js></script>';
		/*$resources[] ='<script>';
		$resources[] ='isc.currentSkin = isc.params.skin;';
		$resources[] ='if (isc.currentSkin == null) isc.currentSkin = "Enterprise";';
		$resources[] ='isc.FileLoader.loadSkin(isc.currentSkin, "showExplorer()");';
		$resources[] ='</script>';
		*/
		
		return $resources;
	}
}

?>
