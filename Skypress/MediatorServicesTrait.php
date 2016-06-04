<?php

namespace YurPlanSkypress;

trait MediatorServicesTrait
{
    /**
     * @access protected
     */
    protected $services = array();

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
     * 
     * @return MediatorServicesTrait
     */
    public function setServices($services){
        $this->services = $services;

        return $this;

    }
}