<?php

namespace Skypress\Component\Factory;

use Skypress\Component\Models\HooksInterface;


use Skypress\Component\Manager\GeneralManager;
use Skypress\Component\Manager\FrontManager;
use Skypress\Component\Manager\BackManager;

use Skypress\Component\Models\Factory\StaticFactoryInterface;



if(!class_exists('ManagerFactory')){

	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class ManagerFactory implements StaticFactoryInterface {

		/**
		 * @since 0.5
		 * @version 0.5
		 *
		 * @staticvar array
		 */
		private static $managers = array();

		/**
		 * Remove a manager
		 * @param  string $key
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
		 *
		 * @return array
		 */
		public static function removeManager( $key){
			unset(self::$managers[$key]);
			return self::$managers;
		}

		/**
		 * Set a manager
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
		 *
		 * @param String $key
		 * @param HooksInterface $manager
		 */
		public static function setManager( $key, HooksInterface $manager){
			self::$managers[$key] = $manager;
			return self::$managers;
		}

		/**
		 * Get all maangers
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
		 *
		 * @param  $configManagers
		 * @return array
		 */
		public static function getManagers($configManagers = null){

			return self::$managers;
		}

		/**
		 * Get a manager
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * @static
		 *
		 * @param  String $key
		 * @return un manager
		 */
		public static function getManager( $key){

			return self::$managers[$key];
		}

		  /**
         * Construct manager factory
         *
         * @since 0.5
		 * @version 0.5
		 * @access private
		 * @static
         *
         * @param  array $config
         * @return void
         */
        public static function create($configManagers = array()){


        	if(!empty($configManagers) && is_array($configManagers)):

	        	foreach ($configManagers as $key => $value):
	        		if($value['active']):

	        			if(isset($value['construct'])):
	        				  $valueConstructeur = $value['construct'];
	        			endif;

	        			switch ($key) :
	        				case 'back':
	        					if(is_admin()):
        							self::setManager($key, new BackManager($valueConstructeur));
        						endif;
	        					break;

	                        case 'front':
	                         	self::setManager($key, new FrontManager($valueConstructeur));
	        					break;

	        				default:
	        					do_action('execute_manager_' . $key);
	        					break;

	        			endswitch;

	        		endif;

	        	endforeach;

	        else:
	        	throw new \Exception("Your configuration is not correct");

	        endif;

        }
	}

}
