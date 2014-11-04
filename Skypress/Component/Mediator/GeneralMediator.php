<?php 




namespace Skypress\Component\Mediator;

use Skypress\Component\Models\iHooks;
use Skypress\Component\Models\iConfig;
use Skypress\Component\Models\iMediator;
use Skypress\Component\Models\iCollegue;


if(!class_exists('GeneralMediator')){

	/**
	 * @abstract
	 * @version 0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	abstract class GeneralMediator implements iMediator {

		/**
		 * @since 0.5
		 * @version 0.5
		 * @access protected
		 * 
		 * @var array
		 */
		protected $collegues;


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
				
			if(!empty($collegues)):
				$this->collegues = $this->setCollegues();
			endif;
		}

		/**
		 * Implements iMediator
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @param array $collegues
		 */
		public function setCollegues($collegues){
			
			if(is_array($collegues)):
				$this->collegues = $collegues;
			else:
				throw new Exception("Votre argument doit être un tableau");
			endif;

			return $this;
			
		}

		/**
		 * Implements iMediator
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @return array 
		 */
		public function getCollegues(){
			return $this->collegues;
		}

		/**
		 * Implements iMediator
		 * 
		 * @param iCollegue $collegue
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 */
		public function setCollegue($collegue){

			if($collegue instanceOf iCollegue):

				$classname = get_class($collegue);

				if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
			        $classname = $matches[1];
			    }

				$this->collegues[$classname] = $collegue; 

			endif;

			return $this;
		}

		/**
		 * Implements iMediator
		 * 
		 * @param  string $key
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 * 
		 * @return iCollegue 
		 */
		public function getCollegue($key){

			$collegues = $this->getCollegues();

			if(array_key_exists($key, $collegues ) ):
				return  $collegues[$key];
			endif;

			return null;
		}
	
	}

}