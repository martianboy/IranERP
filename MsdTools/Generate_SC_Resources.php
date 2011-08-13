<?php
require_once 'SmartClientAnnotation.php';
use 
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Doctrine\ORM\Mapping\ClassMetadataInfo,
    Doctrine\ORM\Mapping\MappingException;
    
function parseObjectToArray($object) {

    $array = array();
    if (is_object($object)) {
        $array = get_object_vars($object);
    }
    return $array;
}

function GetSimpleDataSource($ClassName,$ExceptedProperties)

{
	$reader = new AnnotationReader();
	$reader->setDefaultAnnotationNamespace('.');
	//Get All scget functions in Class
	$rtnval='';
	$methods = get_class_methods($ClassName);
	foreach($methods as $m){
	
		if(substr($m,0,5)=='scget'){
			if(is_array($ExceptedProperties)) 
				if (in_array(substr($m,5),$ExceptedProperties)) {continue;}
			$rtnval.='{';
			$relmethod = new ReflectionMethod($ClassName,$m);
			$methoddefine = $reader->getMethodAnnotations($relmethod);
			foreach($methoddefine as $annots)
			if(is_a($annots,'scField')) 
					foreach(parseObjectToArray($annots) as $k=>$v)
						if($v!=null) {
							switch($k){
								case "canEdit":
								case "canExport":
								case "canFilter":
								case "canSave":
								case "canSortClientOnly":
								case "detail":
								case "hidden":
								case "primaryKey":
									$rtnval.=$k.':"'.($v?"true":"false").'",';
									break;
								case "childrenProperty":
								case "childTagName":
								case "editorType":
								case "foreignKey":
								case "name":
								case "type":
								case "title":
					
									$rtnval.=$k.':"'.$v.'",';
									break;
									
							}
							
						}

			$rtnval = substr($rtnval,0,strlen($rtnval)-1);
			$rtnval.='},';
			}
			
		}
	   $rtnval = substr($rtnval,0,strlen($rtnval)-1);
	   $rtnval='isc.RestDataSource.create({ID:"'.$ClassName.'",fields:['.$rtnval.']';
	   $rtnval.='})';
		return $rtnval;
	}


	function GetCompleteDataSource($ClassName,$EM)
	{
	$rtnval ='';
	$rtnval = GetSimpleDataSource($ClassName,null);
	//Get Related Classes
	foreach($EM->getClassMetadata($ClassName)->associationMappings as $a)
	$rtnval.=GetSimpleDataSource($a['targetEntity'],null);
	return $rtnval;
	} 
?>
