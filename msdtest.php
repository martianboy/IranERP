<?php 
require_once 'DefineClasses.php';
require_once 'bootstrap.php';
require_once 'MsdTools/Generate_SC_Resources.php';
require_once 'MsdTools/Common.php';

/*require_once 'Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php';*/
use Doctrine\Common\Cache\ArrayCache,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\AnnotationRegistry,
    Doctrine\ORM\Mapping\ClassMetadataInfo,
    Doctrine\ORM\Mapping\MappingException;

      $reader = new AnnotationReader();
      $reader->setDefaultAnnotationNamespace('.');
            
/*$Drv =  Doctrine\ORM\Mapping\Driver\AnnotationDriver::create();
$reader = $Drv->GetReader();
*/
//print_r($em->getClassMetadata('Magazine'));
//echo Common::TranslateVars('MenuItemParentID', 'MenuItem', '.');
echo GetCompleteDataSource('MenuItem', $em);


?>