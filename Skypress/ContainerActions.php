<?php

namespace Skypress;

use Skypress\Models\ContainerInterface;
use Skypress\Models\ContainerServiceInterface;
use Skypress\Models\HooksInterface;
use Skypress\ContainerServiceTrait;

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