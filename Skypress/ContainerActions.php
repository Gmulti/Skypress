<?php

namespace YurPlanSkypress;

use YurPlanSkypress\Models\ContainerInterface;
use YurPlanSkypress\Models\ContainerServiceInterface;
use YurPlanSkypress\Models\HooksInterface;
use YurPlanSkypress\ContainerServiceTrait;

class ContainerActions extends Container implements ContainerInterface
{

    public function getActions(){
        return $this->getServices();
    } 


    /**
     * @param string $key
     */
    public function getAction($key){
        
        return $this->getAction($key);
        
    }

    /**
     * @param HooksInterface $action
     *
     * @return Container
     */
    public function setAction(HooksInterface $action){

        $this->setService($action);
    }

    /**
     * @param HooksInterface[] $services default empty
     *
     * @return Container
     */
    public function setActions($actions = array()){
        $this->setServices($actions);
    }

}