<?php

namespace Skypress;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\Models\ContainerInterface;

trait ContainerServiceTrait {

   /**
     * @var ContainerInterface
     */
    protected $containerServices;

   /**
     * @var ContainerInterface
     */
    protected $containerActions;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $containerServices A ContainerInterface instance or null
     */
    public function setContainerServices(ContainerInterface $containerServices = null)
    {
        $this->containerServices = $containerServices;
        return $this;
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $containerActions A ContainerInterface instance or null
     */
    public function setContainerActions(ContainerInterface $containerActions = null)
    {
        $this->containerActions = $containerActions;
        return $this;
    }

    /**
     * @param string $key
     * @return ServiceInterface
     */
    public function getService($key){
        return $this->containerServices->getService($key);
    }

    /**
     * @return ServiceInterface[]
     */
    public function getServices(){
        return $this->containerServices->getServices();
    }

    /**
     * @param ServiceInterface $service
     * @return ContainerServiceTrait
     */
    public function setService(ServiceInterface $service){
        $this->containerServices->setService($service);
        return $this;
    }

    /**
     * @param ServiceInterface[] $services
     * @return ContainerServiceTrait
     */
    public function setServices($services = array()){
        $this->containerServices->setServices($services);
        return $this;
    }
    
    /**
     * @param string $key
     * @return HooksInterface
     */
    public function getAction($key){
        return $this->containerActions->getAction($key);
    }

    /**
     * @return HooksInterface[]
     */
    public function getActions(){
        return $this->containerActions->getActions();
    }

    /**
     * @param HooksInterface $action
     * @return ContainerServiceTrait
     */
    public function setAction(HooksInterface $action){
        $this->containerActions->setAction($action);
        return $this;
    }

    /**
     * @param HooksInterface[] $actions
     * @return ContainerServiceTrait
     */
    public function setActions($actions = array()){
        $this->containerActions->setActions($actions);
        return $this;
    }

}
