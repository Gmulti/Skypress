<?php

namespace Skypress\Component\Project;

use Skypress\Component\Manager\BackManager;
use Skypress\Component\Manager\FrontManager;
use Skypress\Component\Manager\GeneralManager;

use Skypress\Component\Models\HooksInterface;
use Skypress\Component\Models\OrderInterface;

use Skypress\Component\Factory\ServiceFactory;
use Skypress\Component\Factory\ManagerFactory;

use Skypress\Component\Strategy\MenuStrategy;
use Skypress\Component\Strategy\CustomPostTypeStrategy;

use Skypress\Component\Mediator\ServiceContainerMediator;
use Skypress\Component\Service\MediatorService;


if(!class_exists('MainProject')){

    /**
     * Abstract Main project
     * 
     * @version 0.5
     * @since 0.5
     * @abstract
     *
     * @author Thomas DENEULIN <contact@skypress.fr>
     *
     */
    abstract class MainProject
    {
        /**
         *
         * @since 0.5
         * @version 0.5
         * @access protected
         * @varstatic
         *
         */
        protected static $instance;

        /**
         * @since 0.5
         * @version 0.5
         * @var array
         * @access protected
         */
        protected $managers = array();

        /**
         * @since 0.5
         * @version 0.5
         * @var array
         * @access protected
         */
        protected $services = array();

        protected $sm;

        /**
         * @since 0.5
         * @version 0.5
         * @var boolean
         * @access protected
         */
        protected $local;

        /**
         * Construct
         * @param array $config
         *
         * @since 0.5
         * @version 0.5
         * @access private
         */
        public function __construct($config) {
            
            $this->local = ($_SERVER['REMOTE_ADDR']=='127.0.0.1') ? true : false;
            $this->constructMediators();

            $this->setServices($config['services']);

            ManagerFactory::create($config['managers']);        	
            $this->managers = ManagerFactory::getManagers();

        }


        /**
         * Execute framework
         *
         * @version 0.5
         * @since 0.5
         * @access public
         *
         * @return this
         */
        public function execute(){

            $orderLaunch = array();

            foreach ($this->getManagers() as $key => $manager):

                if($manager instanceOf HooksInterface):
                    $manager->hooks();
                endif;

            endforeach;

            foreach ($this->getServices() as $key => $service):

                if($service instanceOf HooksInterface):
                    if($service instanceOf OrderInterface):
                        $orderLaunch[$service->getOrder()] = $service;
                    else:
                        $service->hooks();
                    endif;
                endif;

            endforeach;

            if(!empty($orderLaunch)):
                foreach($orderLaunch as $key => $service):
                    $service->hooks();
                endforeach;
            endif;
        }


        /**
         * Get all services
         *
         * @version 0.5
         * @since 0.5
         * @access public
         *
         * @return services
         */
        public function getServices(){
        	return $this->sm->getServices();
        }

        /**
         * Get a service
         *
         * @version 0.5
         * @since 0.5
         * @access public
         * @param string $key
         * @param int $create
         *
         * @return service
         */
        public function getService($key, $create = 0){
            $services = $this->getServices();
            if(array_key_exists($key, $services)):
                return $services[$key];
            elseif($create):
                return $this->createService($key);
            endif;

            return null;

        }

        /**
         * Set config services
         *
         * @version 0.5
         * @since 0.5
         * @access public
         * @param array $config
         *
         */
        public function setServices($config){

            ServiceFactory::create($config);

        }

        /**
         * Add a service
         *
         * @version 0.5
         * @since 0.5
         * @access public
         *
         * @param string $key
         * @param service $value
         *
         */
        public function addService($key, $value){

            ServiceFactory::add($key, $value);

            return $this;
        }

        /**
         * Active a service by key
         *
         * @version 0.5
         * @since 0.5
         * @access public
         *
         * @param string $key
         *
         */
        public function activeService($key){

            if($this->getService($key) == null):
               return $this->createService($key);
            endif;

            return $this;
        }

        /**
         * Create a service
         *
         * @version 0.5
         * @since 0.5
         * @access private
         *
         * @param string $key
         *
         */
        private function createService($key){
            ServiceFactory::create($key);

            $services = $this->getServices();
            if(array_key_exists($key,  $services)):
                return $services[$key];
            endif;

            return null;
        }

        /**
         * Get all managers
         *
         * @version 0.5
         * @since 0.5
         * @access public
         *
         * @return services
         */
        public function getManagers(){
            return $this->managers;
        }

        /**
         * @todo Ce n'est pas au projet de construire les mediators
         */
        public function constructMediators(){   
            
            $ServiceContainerMediator = new ServiceContainerMediator();

            $this->sm = $ServiceContainerMediator;

            $array_mediatorService = array(
                $ServiceContainerMediator,
            );

            MediatorService::setMediators($array_mediatorService);
        }


    }

}
