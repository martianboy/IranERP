<?php
/**
 * This Class Trye To Load IRanerp Classes 
 * all Classes That Use In IranErp Defined In IranERp Namespace
 */
class IR_ClassLoader extends CApplicationComponent
{
	function init(){
		
		\Yii::trace('#@! -- IRClassLoader is Initializing');
		\Yii::registerAutoloader(array($this,'LoadIRanClasses'));
		\Yii::trace('#@! -- IRClassLoader Initialized');
		parent::init();
		
	}
	function LoadIRanClasses($classname)
	{
		\Yii::trace('#@! -- Request To Load '.$classname);
		//Detect That namespce is IRERP
		$secs = explode("\\", $classname);
		if(isset($secs[0]))
			if($secs[0]=='IRERP')
			{
			 $path =\Yii::app()->basePath;
			 for($i=1;$i<count($secs);$i++) $path=$path.DIRECTORY_SEPARATOR.$secs[$i];
			 $path=$path.'.php';
			 \Yii::trace('#@! -- Try To Include '.$path);
			 //Check That File Exist?
			 if(file_exists($path)){
			 	require $path;			 
			 	return true;
			 }
			 else return false;
			}
		return FALSE;
	}
	public function nop(){}
}
?>