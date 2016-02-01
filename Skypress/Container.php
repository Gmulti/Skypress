<?php

namespace Skypress;

use Skypress\Models\ContainerInterface;
use Skypress\Models\ServiceInterface;

class Container implements ContainerInterface
{
    /**
     * @access protected
     */
    protected $services = array();

    /**
     * @param array $array
     */
    public function __construct($array = array()){
        $this->setServices($array);
    }

    public function getServices(){
        return $this->services;
    } 


    /**
     * @param string $key
     */
    public function getService($key){
        
        if(array_key_exists($key, $this->services)){
            return $this->services[$key];
        }

        return null;
        
    }

    /**
     * @param ServiceInterface $service
     *
     * @return Container
     */
    public function setService(ServiceInterface $service){

        $classname = get_class($service);

        if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
            $classname = $matches[1];
        }

        $classname = apply_filters("_container_set_service_classname", $classname);

        $this->services[$classname] = $service;

        return $this;
    }

    /**
     * @param ServiceInterface[] $services default empty
     *
     * @return Container
     */
    public function setServices($services = array()){
        $services = apply_filters("_container_set_services", $services);

        foreach ($services as $key => $service) {
            $this->setService($service);
        }

        return $this;

    }
}