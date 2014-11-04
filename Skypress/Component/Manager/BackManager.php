<?php 

namespace Skypress\Component\Manager;




use Skypress\Component\Models\iHooks;

if(!class_exists('BackManager'))
{
	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class BackManager extends GeneralManager implements iHooks {

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
			parent::__construct($config);
		}

		/**
		 * Implements iHooks
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @return  void
		 */
		public function hooks(){

			
		}

	}
}

	