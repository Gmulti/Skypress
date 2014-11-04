<?php 

namespace Skypress\Component\Mediator;


if(!class_exists('ServiceMediator')){

	/**
 	 *
	 * @version 0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class ServiceMediator extends GeneralMediator{

		/**
		 * Construct
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @param  $collegues 
		 */
		public function __construct($collegues = array()){
				
			parent::__construct();
		}
	
	}

}