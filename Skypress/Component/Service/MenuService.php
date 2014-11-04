<?php 

namespace Skypress\Component\Service;

use Skypress\Component\Models\iHooks;
use Skypress\Component\Models\iConfig;


if(!class_exists('MenuService')){
	
	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class MenuService implements iHooks, iConfig {

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
		 * Implements iHooks
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
		 * Implements iConfig
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
				throw new Exception("Le paramètre doit être un tableau");
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