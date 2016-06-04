<?php

namespace Skypress\Models;

use Skypress\Models\ServiceInterface;

/**
 * @version 1.0.0
 * @since 1.0.0
 * 
 * @author Thomas DENEULIN <contact@wp-god.com> 
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