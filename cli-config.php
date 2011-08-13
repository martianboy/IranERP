<?php
require_once  'Doctrine/Common/ClassLoader.php';
require_once 'Doctrine/Symfony/Component/Console/Helper/HelperSet.php';
require_once 'User.php';
require_once 'Bug.php';
require_once 'Product.php';

$classLoader = new \Doctrine\Common\ClassLoader('Doctrine', '.');
$classLoader->register(); // register on SPL autoload stack
$classLoader = new \Doctrine\Common\ClassLoader('Symfony', 'Doctrine');
$classLoader->register();
use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration,
    Doctrine\DBAL,Symfony\Component\Console\Helper;

$applicationMode ='development';

if ($applicationMode == "development") {
    $cache = new \Doctrine\Common\Cache\ArrayCache;
} else {
    $cache = new \Doctrine\Common\Cache\ApcCache;
}

$config = new Configuration;
$config->setMetadataCacheImpl($cache);

$driverImpl = $config->newDefaultAnnotationDriver('.');
$config->setMetadataDriverImpl($driverImpl);

$config->setQueryCacheImpl($cache);



$config->setProxyDir('.');
$config->setProxyNamespace('.');

if ($applicationMode == "development") {
    $config->setAutoGenerateProxyClasses(true);
} else {
    $config->setAutoGenerateProxyClasses(false);
}

//Making Connection To Db
$connectionParams = array(
    'dbname' => 'JAHADDoctorine',
    'user' => 'JAHADDoctorine',
    'password' => 'JAHADDoctorine',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
);


$conn = Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);

//$evm = new Doctrine\Common\EventManager();
$em = EntityManager::create($conn, $config);
$em = EntityManager::create($conn, $config);
$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
	'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
));

$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
$classes = array(
  $em->getClassMetadata('User'),
  $em->getClassMetadata('Bug'),
  $em->getClassMetadata('Product')
);
print_r($tool->getCreateSchemaSql($classes));
$tool->createSchema($classes);
?>
