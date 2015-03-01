<?php 


namespace Skypress\Component\Strategy\XML;

use Skypress\Component\Models\Strategy\ParameterInterface;

if(!class_exists('ParameterStrategy')){
	/**
 	 *
	 * @version 0.6
	 * @since 0.6
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class ParameterStrategy implements ParameterInterface {

		/**
	 	 * 
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 * @var string
		 */
		protected $file;

		/**
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 * @param string $file
		 */
		public function __construct($file = null){
			$this->addFile($file);
		}

		/**
	 	 * Add a file for a configuration
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public
		 * @param string $file
		 */
		public function addFile($file){
			$this->file = $file;
			return $this;
		}

		/**
	 	 * Get file
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 */
		public function getFile(){
			return $this->file;
		}

	}
}
