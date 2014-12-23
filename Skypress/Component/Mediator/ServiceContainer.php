<?php 

namespace Skypress\Component\Mediator;


if(!class_exists('ServiceContainer')){

	/**
 	 *
	 * @version 0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class ServiceContainer extends GeneralMediator{

		/**
		 * Construct
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @param  $colleagues 
		 */
		public function __construct($colleagues = array()){
				
			parent::__construct();
		}
		/**
		 * Return all services
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 */
		public function getServices(){
			$result = $this->getColleagues();
			if($result === null):
				return array();
			endif;

			return $result;
		}

		/**
		 * Return all services
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 *
		 * @param string $key 
		 */
		public function getService($key){
			$this->getColleague($key);
		}

		/**
		 * Set a service
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 *
		 * @param  $service 
		 */
		public function setService($service){
			$this->setColleague($service);
		}
	}
}
