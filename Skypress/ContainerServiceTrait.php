<?php

namespace Skypress;

use Skypress\Models\ContainerInterface;

trait ContainerServiceTrait {

   /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        return $this;
    }

    public function getService($key){
        return $this->container->getService($key);
    }

    public function getServices(){
        return $this->container->getServices();
    }

    public function setService(ServiceInterface $service){
        $this->container->setService($service);
        return $this;
    }

    public function setServices($services = array()){
        $this->container->setServices($services);
        return $this;
    }

}
