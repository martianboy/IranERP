<?php
require_once  'Doctrine/Common/ClassLoader.php';
require_once 'MsdTools/config.php';

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

$driverImpl = $config->newDefaultAnnotationDriver('./JAHAD_Entities');
$config->setMetadataDriverImpl($driverImpl);

$config->setQueryCacheImpl($cache);



$config->setProxyDir('./JAHAD_Entities');
$config->setProxyNamespace('./JAHAD_Entities');

if ($applicationMode == "development") {
    $config->setAutoGenerateProxyClasses(true);
} else {
    $config->setAutoGenerateProxyClasses(false);
}

//Making Connection To Db
$connectionParams = array(
    'dbname' =>dbname,
    'user' => user,
    'password' => password,
    'host' => host,
    'driver' => driver,
);


$conn = Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
$conn->setCharset('UTF8');
$em = EntityManager::create($conn, $config);


?>
