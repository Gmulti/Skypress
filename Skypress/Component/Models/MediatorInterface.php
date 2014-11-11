<?php 


namespace Skypress\Component\Models;

/**
 *
 * Interface mediator
 * 
 * @version 0.5
 * @since 0.5
 * 
 * @author Thomas DENEULIN <contact@skypress.fr> 
 * 
 */
interface MediatorInterface{

	/**
	 * @version 0.5
 	 * @since 0.5
 	 * @access public
 	 * 
	 * @return array
	 */
	public function getColleagues();	

	/**
	 * @version 0.5
 	 * @since 0.5
 	 * @access public
 	 * 
	 */
	public function setColleagues($collegues);	

	/**
	 * @version 0.5
 	 * @since 0.5
 	 * @access public
 	 * 
	 * @return
	 */
	public function getColleague($key);	

	/**
	 * @version 0.5
 	 * @since 0.5
 	 * @access public
 	 * 
	 */
	public function setColleague($collegue);	
}