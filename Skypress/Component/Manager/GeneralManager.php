<?php 

namespace Skypress\Component\Manager;




use Skypress\Component\Models\HooksInterface;
use Skypress\Component\Models\ConfigInterface;


if(!class_exists('GeneralManager')){

	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class GeneralManager implements HooksInterface, ConfigInterface{

		/**
		 * @since 0.5
		 * @version 0.5
		 * @access protected
		 * 
		 * @var array
		 */
		protected $configManager;


		/**
		 * Construct
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @param  $config 
		 */
		public function __construct($config){
				
			$this->configManager = $config[0];

		}

		/**
		 * Implements HooksInterface
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @return void
		 */
		public function hooks(){
			
		}




		/**
		 * Get config
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @return array 
		 */
		public function getConfig(){
			return $this->configManager;
		}

		/**
		 * Set config
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @param array $config
		 */
		public function setConfig($config){
			$this->configManager = $config;
			return $this;
		}

	
	}

}