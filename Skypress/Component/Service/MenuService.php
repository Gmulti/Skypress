<?php 

namespace Skypress\Component\Service;

use Skypress\Component\Models\HooksInterface;
use Skypress\Component\Models\ConfigInterface;


if(!class_exists('MenuService')){
	
	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class MenuService implements HooksInterface, ConfigInterface {

		/**
		 * Liste menus
		 * 
		 * @var array
		 * @version 0.5
		 * @since 0.5
		 * @access private
		 * 
		 */
		private $menus = array();
		
		/**
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 * 
		 * @param array $menus
		 */
		public function __construct($menus){

			$this->menus = $menus;
		}

		/**
		 * Implements HooksInterface
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 * 
		 * @return void 
		 */
		public function hooks(){

			register_nav_menus($this->getConfig());

		}

		/**
		 * Implements ConfigInterface
		 * 
		 * @param array $config
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 * 
		 */
		public function setConfig($config){

			if(is_array($config)):
				$this->menus = $config;
			else:
				throw new Exception("The parameter must be an array");
			endif;

			return $this;
		}

		/**
		 * Get all menus
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 * 
		 * @return array 
		 */
		public function getConfig(){
			return $this->menus;
		}
	}
}
