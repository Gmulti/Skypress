<?php 



namespace Skypress\Component\Service;

use Skypress\Component\Models\ColleagueInterface;
use Skypress\Component\Models\MediatorInterface;

if(!class_exists('ColleagueService')):

	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	abstract class ColleagueService implements ColleagueInterface{

		/**
		 * 
		 * @version 0.5
 		 * @since 0.5
		 * @var protected
		 * @access protected
		 */
		protected $mediator;

		/**
		 * Implements ColleagueInterface
		 *
		 * @version 0.5
 		 * @since 0.5
 		 * @access public
 		 * 
		 * @return MediatorInterface 
		 */
		public function getMediator(){
			return $this->mediator;
		}

		/**
		 * Implements ColleagueInterface
		 * 
		 * @version 0.5
 		 * @since 0.5
 		 * @access public
 		 * 
		 * @param MediatorInterface $mediator
		 */
		public function setMediator(MediatorInterface $mediator){
			$this->mediator = $mediator;
			return $this;
		}

	}


endif;