<?php 
/**
 * Plugin Name: Skypress
 * Plugin URI: http://skypress.fr
 * Description: Framework Skypress pour WordPress
 * Version: 0.5
 * Author: GTD-IT
 */

require_once(__DIR__ . '/skypress/vendor/autoload.php');

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();

$theme = wp_get_theme();
$name  = $theme->template;
$dir   = $theme->theme_root . '/' . $name;


define('NAME_THEME_SP',$name);
define('DIR_THEME_SP', $dir);


$loader->registerNamespaces(array(
    'Skypress' => __DIR__ ,
    ucfirst($name) => $dir . '/src', 
));

$loader->register();
















