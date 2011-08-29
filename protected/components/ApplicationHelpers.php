<?php 
require_once 'scField.php';
use 
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Doctrine\ORM\Mapping\ClassMetadataInfo,
    Doctrine\ORM\Mapping\MappingException;

class ApplicationHelpers
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