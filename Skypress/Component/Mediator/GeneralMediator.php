<?php 




namespace Skypress\Component\Mediator;

use Skypress\Component\Models\HooksInterface;
use Skypress\Component\Models\ConfigInterface;
use Skypress\Component\Models\MediatorInterface;
use Skypress\Component\Models\ColleagueInterface;


if(!class_exists('GeneralMediator')){

	/**
	 * @abstract
	 * @version 0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	abstract class GeneralMediator implements MediatorInterface {

		/**
		 * @since 0.5
		 * @version 0.5
		 * @access protected
		 * 
		 * @var array
		 */
		protected $colleagues = array();


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
				
			if(!empty($colleagues)):
				$this->colleagues = $this->setColleagues();
			endif;
		}

		/**
		 * Implements MediatorInterface
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @param array $colleagues
		 */
		public function setColleagues($colleagues){
			
			if(is_array($colleagues)):
				$this->colleagues = $colleagues;
			else:
				throw new Exception("Your argument should be an array");
			endif;

			return $this;
			
		}

		/**
		 * Implements MediatorInterface
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @return array 
		 */
		public function getColleagues(){
			return $this->colleagues;
		}

		/**
		 * Implements MediatorInterface
		 * 
		 * @param ColleagueInterface $colleague
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 */
		public function setColleague($colleague){


			$classname = get_class($colleague);

			if (preg_match('@\\\\([\w]+)$@', $classname, $matches)):
		        $classname = $matches[1];

	
			$this->colleagues[$classname] = $colleague; 

			endif;

			return $this;
		}

		/**
		 * Implements MediatorInterface
		 * 
		 * @param  string $key
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @return ColleagueInterface 
		 */
		public function getColleague($key){

			$colleagues = $this->getColleagues();

			if(array_key_exists($key, $colleagues ) ):
				return  $colleagues[$key];
			endif;

			return null;
		}
	
	}

}