<?php

namespace Skypress\Component\Factory;

use Skypress\KernelSkypress;

use Skypress\Component\Service\MenuService;
use Skypress\Component\Service\CustomPostTypeService;
use Skypress\Component\Service\TaxonomyService;
use Skypress\Component\Service\MediatorService;
use Skypress\Component\Service\TermService;
use Skypress\Component\Service\Utils\ParameterService;

use Skypress\Component\Factory\CustomPostTypeFactory;
use Skypress\Component\Factory\TaxonomyFactory;
use Skypress\Component\Factory\TermFactory;

use Skypress\Component\Models\Factory\StaticFactoryInterface;
use Skypress\Component\Models\ColleagueInterface;


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
	class ServiceFactory implements StaticFactoryInterface {

		/**
		 * Add a service
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access private
		 * @static
		 *
		 * @param String $key
		 * @param array $service
		 */
		private static function addService($service){
			$sc = MediatorService::getMediator('ServiceContainer');
			$sc->setService($service);
		}

		/**
		 * Get a service
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access private
		 * @static
		 *
		 * @param  String $key
		 * @return array      a service
		 */
		private static function getService($key){
			$sc = MediatorService::getMediator('ServiceContainer');
			return $sc->getService($key);
		}

		/**
         * Construct service factory
         *
         * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
         *
         * @param  (array|string) $config
         * @return void
         */
        public static function create($configServices = array()){


        	if(!empty($configServices)):

        		if(is_array($configServices)):
	        		
	        		foreach ($configServices as $key => $value):

	        			if(self::getService($key) === null):
			        		$value = apply_filters('service_factory_construct_' . $key . '_' . KernelSkypress::getTypeFilter(), $value);
			        		
			        		if($value['active']):

			        			$valueConstructeur = '';

			        			if(isset($value['construct'])):

			        				$valueConstructeur = $value['construct'];

			        			endif;

			        			self::createService($key,$valueConstructeur);

			        		endif;
			        	endif;

		        	endforeach;
	        	elseif(is_string($configServices) && self::getService($configServices) === null):

	        		self::createService($configServices);

	        	endif;

	        else:
	        	throw new \Exception("Your configuration is not correct");

	        endif;

        }


        /**
         * @since 0.5
		 * @version 0.5
		 * @access private
		 * @static
         *
         * @param  string $key
         * @param  array $valueConstruct
         * @return void
         */
        private static function createService($key, $valueConstructeur = ''){

        	switch ($key) :

				case 'menu':
					$service = new MenuService($valueConstructeur);
					break;

	            case 'custom-post-type':
	            case 'CustomPostTypeService':
	            	// Choose custom post type factory
					$factory = new CustomPostTypeFactory();
					$factory = apply_filters( 'factory_' . $key . '_' . KernelSkypress::getTypeFilter(), $factory );

					// Choose custom post type service with set up factory
	            	$service = new CustomPostTypeService($factory, $valueConstructeur);

	                break;

				case 'taxonomy':
				case 'TaxonomyService':
					// Choose taxonomy factory
					$factory = new TaxonomyFactory();
					$factory = apply_filters( 'factory_' . $key . '_' . KernelSkypress::getTypeFilter(), $factory );

					// Choose taxonomy service with set up factory
	            	$service = new TaxonomyService($factory,$valueConstructeur);

	                break;

	            case 'term':
	            case 'TermService':

					// Choose taxonomy factory
					$factory = new TermFactory();
					$factory = apply_filters( 'factory_' . $key . '_' . KernelSkypress::getTypeFilter(), $factory );

					// Choose taxonomy service with set up factory
	            	$service = new TermService($factory, $valueConstructeur);

	                break;

	            case 'ParameterService':
	            	$service = new ParameterService();
	            	break;

	            default:
	                $service = apply_filters( 'service_' . $key . '_' . KernelSkypress::getTypeFilter(),  '');
	            	break;

			endswitch;

			$service = apply_filters( 'service_' . $key . '_' . KernelSkypress::getTypeFilter(),  $service);

		 	self::addService($service);

			if($service instanceOf ColleagueInterface):
				$sc = MediatorService::getMediator('ServiceContainer');			
				$service->setMediator($sc);
			endif;
        }
	}
}
