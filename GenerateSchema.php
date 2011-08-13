<?php
require_once 'bootstrap.php';
require_once 'DefineClasses.php';
$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
	'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
$classes=array();
foreach($DBClasses as $class) $classes[]=$em->getClassMetadata($class);
print_r($tool->getCreateSchemaSql($classes));
$tool->updateSchema($classes);
?>