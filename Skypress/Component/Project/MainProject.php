<?php

namespace Skypress\Component\Project;

use Skypress\Component\Manager\BackManager;
use Skypress\Component\Manager\FrontManager;
use Skypress\Component\Manager\GeneralManager;

use Skypress\Component\Models\iSingletonMain;
use Skypress\Component\Models\iServiceManager;
use Skypress\Component\Models\iHooks;
use Skypress\Component\Models\iOrder;

use Skypress\Component\Factory\ServiceFactory;
use Skypress\Component\Factory\ManagerFactory;

use Skypress\Component\Strategy\MenuStrategy;
use Skypress\Component\Strategy\CustomPostTypeStrategy;

use Skypress\Component\Mediator\ServiceMediator;
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

            ServiceFactory::create($config['services']);
            ManagerFactory::create($config['managers']);

        	$this->services = ServiceFactory::getServices();

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

                if($manager instanceOf iHooks):
                    $manager->hooks();
                endif;

            endforeach;

            foreach ($this->getServices() as $key => $service):

                if($service instanceOf iHooks):
                    if($service instanceOf iOrder):
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
        	return $this->services;
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

        public function constructMediators(){   
            
            $serviceMediator = new ServiceMediator();

            $array_mediatorService = array(
                $serviceMediator,
            );

            MediatorService::setMediators($array_mediatorService);
        }


    }

}
