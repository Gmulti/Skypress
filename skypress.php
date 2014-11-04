<?php 
/**
 * Plugin Name: Skypress
 * Plugin URI: http://skypress.fr
 * Description: Framework Skypress pour WordPress
 * Version: 0.5
 * Author: GTD-IT
 */

require_once(__DIR__ . '/skypress/vendor/SplClassLoader.php');
require_once(__DIR__ . '/skypress/Component/constantes.php');


$loader = new SplClassLoader('Skypress',__DIR__ );
$loader->register();

$loader = new SplClassLoader('Component\Models',__DIR__ . '/Skypress' );
$loader->register();

$loader = new SplClassLoader('Component\Factory',__DIR__ . '/Skypress');
$loader->register();

$loader = new SplClassLoader('Component\Service',__DIR__ . '/Skypress');
$loader->register();

$loader = new SplClassLoader('Component\Manager',__DIR__ . '/Skypress');
$loader->register();

$loader = new SplClassLoader('Component\Project',__DIR__ . '/Skypress');
$loader->register();

$loader = new SplClassLoader('Component\Strategy',__DIR__ . '/Skypress');
$loader->register();

$loader = new SplClassLoader('Component\Entity',__DIR__ . '/Skypress');
$loader->register();

$loader = new SplClassLoader('Component\Mediator',__DIR__ . '/Skypress');
$loader->register();

?>














