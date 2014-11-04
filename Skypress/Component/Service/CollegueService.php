<?php 



namespace Skypress\Component\Service;

use Skypress\Component\Models\iCollegue;
use Skypress\Component\Models\iMediator;

if(!class_exists('CollegueService')):

	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	abstract class CollegueService implements iCollegue{

		/**
		 * 
		 * @version 0.5
 		 * @since 0.5
		 * @var protected
		 */
		protected $mediator;

		/**
		 * Implements iCollegue
		 *
		 * @version 0.5
 		 * @since 0.5
 		 * 
		 * @return iMediator 
		 */
		public function getMediator(){
			return $this->mediator;
		}

		/**
		 * Implements iCollegue
		 * 
		 * @version 0.5
 		 * @since 0.5
 		 * 
		 * @param iMediator $mediator
		 */
		public function setMediator(iMediator $mediator){
			$this->mediator = $mediator;
			return $this;
		}

	}


endif;