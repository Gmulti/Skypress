<?php 

namespace Skypress\Component\Service;

use Skypress\Component\Models\MediatorInterface;

if(!class_exists('MediatorService')){

	/**
	 *
	 * @version customversionstring0.5
	 * @since 0.5
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class MediatorService {

		/**
		 * @version 0.5
 		 * @since 0.5
 		 * @access protected
 		 * @static
 		 * 
		 * @var array
		 */
		protected static $mediators = array();

		/**
		 *
		 * @access public
		 * @version 0.5
 		 * @since 0.5
 		 * @static
 		 * 
		 * @param MediatorInterface $mediator [description]
		 */
		public static function setMediator(MediatorInterface $mediator){

			$classname = get_class($mediator);

			if (preg_match('@\\\\([\w]+)$@', $classname, $matches)) {
		        $classname = $matches[1];
		    }

			if(!array_key_exists($classname, self::$mediators)):
				self::$mediators[$classname] = $mediator;
			endif;
		}

		/**
		 * 
		 * @version 0.5
 		 * @since 0.5
 		 * @access public
 		 * @static
 		 * 
		 * @param array $mediators
		 */
		public static function setMediators($mediators){

			foreach ($mediators as $key => $mediator):
				if($mediator instanceOf MediatorInterface):
					self::setMediator($mediator);
				endif;
			endforeach;
		}
		
		/**
		 * @version 0.5
 		 * @since 0.5
 		 * @access public
 		 * @static
 		 *        
		 * @return array
		 */
		public static function getMediators(){
			return self::$mediators;
		}

		/**
		 * Get mediator
		 * 
		 * @param  string $key 
		 *
		 * @version 0.5
 		 * @since 0.5
 		 * @access public
 		 * @static
 		 * 
		 * @return (mediator|null)
		 */
		public static function getMediator($key){
			if(array_key_exists($key, self::$mediators)):
				return self::$mediators[$key];
			endif;

			return null;
		}
	
	}

}