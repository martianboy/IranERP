<?php 
require_once 'SmartClientAnnotation.php';
use 
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Doctrine\ORM\Mapping\ClassMetadataInfo,
    Doctrine\ORM\Mapping\MappingException;

class Common
{
	/**
	 * 
	 * Convert Object To Array 
	 * 
	 * @param Object $object
	 */
public static function parseObjectToArray($object) {
    $array = array();
    if (is_object($object)) {
        $array = get_object_vars($object);
    }
    return $array;
}
	
	/**
	 * 
	 * Tries To Retrive VarName From QueryString or $_GET or $_POST
	 * if it can not find VarName in Array
	 * @param string $VarName
	 * @param Array $ARRAY
	 */
public static function GetVar($VarName,$ARRAY=NULL)
{
//Get From Query String
if(is_array($ARRAY)){
	if (array_key_exists($VarName, $ARRAY)) return $ARRAY[$VarName];
}
	
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
		if(array_key_exists($VarName,$Variable))
			$rtnval=$Variable[$VarName];
	}catch(Exception $e)
	{
		print_r($e);
	}
	if($rtnval==null){
		if(array_key_exists($VarName, $_GET) && $rtnval==NULL)	$rtnval = $_GET[$VarName];
		if(array_key_exists($VarName, $_POST) && $rtnval==NULL) $rtnval = $_POST[$VarName]; 
	}
	//if($VarName=='criteria') print_r($rtnval);
	//print_r($_SERVER['QUERY_STRING']);
	//print_r($Variable);
	return $rtnval;
}


/**
 * 
 * Translate $VarName To Doctrine Fields Using 
 * scField Annotation Defined in $ClassName
 * for scget or scset methods
 * @param string $VarName
 * @param string $ClassName
 * @param string $namespace
 */
public static function TranslateSCVarsToDoctrine($VarName,$ClassName,$namespace)
{
	$reader= new AnnotationReader();
	$methods = get_class_methods($ClassName);
	foreach ($methods as $methodName)
	{
		if(
			substr($methodName,0,5)=='scget' || 
			substr($methodName,0,5=='scset')
			){
			$reflmethod = new ReflectionMethod($ClassName, $methodName);
			$MethodAnns = $reader->getMethodAnnotations($reflmethod);
			foreach($MethodAnns as $annots)
				if(is_a($annots,'scField'))
					//Check That VarName Defined in $annots
					if($annots->name==$VarName)
					 return $annots->DoctrineField;
		}
	}
	return $VarName;
}
}
?>