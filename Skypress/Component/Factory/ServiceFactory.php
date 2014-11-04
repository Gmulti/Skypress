<?php

namespace Skypress\Component\Factory;

use Skypress\Kernel;
use Skypress\Component\Models\iHooks;

use Skypress\Component\Service\MenuService;
use Skypress\Component\Service\CustomPostTypeService;
use Skypress\Component\Service\TaxonomyService;
use Skypress\Component\Service\MediatorService;
use Skypress\Component\Service\TermService;

use Skypress\Component\Factory\CustomPostTypeFactory;
use Skypress\Component\Factory\TaxonomyFactory;
use Skypress\Component\Factory\TermFactory;

use Skypress\Component\Models\iStaticFactory;
use Skypress\Component\Models\iCollegue;

use Skypress\Component\Mediator\ServicesMediator;


if(!class_exists('ServiceFactory')){

	/**
	 *
	 * Construit tous les services en fonction de ceux qui sont activés
	 * 
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class ServiceFactory implements iStaticFactory {

		/**
		 * @since 0.5
		 * @version 0.5
		 * @access private
		 *
		 * @staticvar array
		 */
		private static $services = array();

		/**
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access private
		 * 
		 * @staticvar
		 * 
		 * @var [type]
		 */
		private static $mediator = null;

		/**
		 * Remove a service
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
		 *
		 * @param  String $key
		 * @return array
		 */
		public static function removeService($key){
			unset(self::$services[$key]);
			return self::$services;
		}

		/**
		 * Add a service
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
		 *
		 * @param String $key
		 * @param array $service
		 */
		public static function addService($key, $service){
			self::$services[$key] = $service;
			return self::$services;
		}

		/**
		 * Get all services
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
		 *
		 * @param  $configServices
		 * @return array
		 */
		public static function getServices(){

			return self::$services;
		}

		/**
		 * Get a service
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
		 *
		 * @param  String $key
		 * @return array      a service
		 */
		public static function getService( $key){

			return self::$services[$key];
		}

		/**
         * Construct service factory
         *
         * @since 0.5
		 * @version 0.5
		 * @access private
		 * @static
         *
         * @param  array $config
         * @return void
         */
        public static function create($configServices = array()){

        	if(!empty($configServices) && is_array($configServices)):

	        	foreach ($configServices as $key => $value):

	        		$value = apply_filters('service_factory_construct_' . $key . '_' . Kernel::getTypeFilter(), $value);

	        		if($value['active']):

	        			$valueConstructeur = '';
	        			$factory = null;

	        			if(isset($value['construct'])):

	        				$valueConstructeur = $value['construct'];

	        			endif;

	        			switch ($key) :

	        				case 'menu':

	        					$service = new MenuService($valueConstructeur);

	        					break;

	                        case 'custom-post-type':

	                        	// Choose custom post type factory
								$factory = new CustomPostTypeFactory();
								$factory = apply_filters( 'factory_' . $key . '_' . Kernel::getTypeFilter(), $factory );

								// Choose custom post type service with set up factory
	                        	$service = new CustomPostTypeService($valueConstructeur,$factory);

	                            break;

	        				case 'taxonomy':

        						// Choose taxonomy factory
								$factory = new TaxonomyFactory();
								$factory = apply_filters( 'factory_' . $key . '_' . Kernel::getTypeFilter(), $factory );

								// Choose taxonomy service with set up factory
	                        	$service = new TaxonomyService($valueConstructeur,$factory);

	                            break;

	                        case 'term':

        						// Choose taxonomy factory
								$factory = new TermFactory();
								$factory = apply_filters( 'factory_' . $key . '_' . Kernel::getTypeFilter(), $factory );

								// Choose taxonomy service with set up factory
	                        	$service = new TermService($factory, $valueConstructeur);

	                            break;

	                        default:

	                        	do_action('execute_service_' . $key, self);
	                        	break;

	        			endswitch;

	        		
						$service = apply_filters( 'service_' . $key . '_' . Kernel::getTypeFilter(),  $service);
					 	self::addService($key, $service);

	        			if($service instanceOf iCollegue):
	        				$mediator = MediatorService::getMediator('ServiceMediator');
	        				$mediator->setCollegue($service);
	        				$service->setMediator($mediator);
	        			endif;

	        		endif;

	        	endforeach;

	        else:
	        	throw new \Exception("Votre configuration n'est pas correct");

	        endif;

        }
	}

}
