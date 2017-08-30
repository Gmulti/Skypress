<?php

namespace Skypress\Models;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\Models\ServiceInterface;

/**
 * @version 1.0.0
 * @since 1.0.0
 * 
 * @author Thomas DENEULIN <thomas@delipress.io> 
 */
interface ContainerInterface {
    /**
     * @param array $array
     */
    public function setServices($array = array());

    /**
     * @param ServiceInterface $service
     */
    public function setService(ServiceInterface $service);

    /**
     * @param string $key
     */
    public function getService($key);
    
    public function getServices();
}