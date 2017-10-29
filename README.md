# Skypress

[![Build Status][travis-image]][travis-url] 

Skypress is a PHP library for WordPress CMS wants to make a response to several issues that revolve around WordPress:

* The Object Oriented Programming
* Maintainability projects
* Versioning
* Code portability

## How use ?

Generate autoload : `composer dump`


## Features

[x] Service Container
[x] Pattern Specification
[ ] Generate custom post type with config file 
[ ] Generate taxonomies with config file 

## Example

```php

<?php

/**
 * Plugin Name: Plugin Example
 * Description: Example plugin
 * Version: 1.0.0
 * Author: Thomas DENEULIN
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: example
 * Domain Path: /languages/
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;

require_once dirname(__FILE__) . "/vendor/autoload.php";

use Skypress\Kernel;
use Skypress\ContainerServices;
use Skypress\ContainerActions;
use Skypress\WordPress\Actions\AbstractHook;

define("PLUGIN_BASE_FILE", plugin_basename( __FILE__ ));

class PluginExample extends Kernel {

    public function __construct(){
        load_plugin_textdomain( "example", false, dirname( PLUGIN_BASE_FILE ) . '/languages');
    }

    public function execute(){

        add_action( 'plugins_loaded' , array($this,'executePlugin'));
        register_activation_hook(__FILE__, array($this, 'executePlugin'));
        register_deactivation_hook(__FILE__, array($this, 'executePlugin'));

    }

}

$services = array(); // Any of your services

$containerServices = new ContainerServices($services);

$prepareActions = array(); // Any of your actions

foreach ($prepareActions as $key => $prepareAction) {
    if($prepareAction instanceOf AbstractHook){
        $prepareAction->setContainerServices($containerServices);
    }
}

$containerActions = new ContainerActions($actions);

$pluginExample  = new PluginExample();
$pluginExample->setContainerServices($containerServices)
			  ->setContainerActions($containerActions)
              ->execute();

```


[twitter-account]: https://twitter.com/TDeneulin
[travis-image]: https://travis-ci.org/Gmulti/Skypress.svg
[travis-url]: https://travis-ci.org/Gmulti/Skypress