<?php 


namespace Skypress\Component\Models;

/**
 *
 * Si l'on a besoin de gérer l'ordre d'éxecution d'une classe
 * 
 * @version 0.5
 * @since 0.5
 * 
 * @author Thomas DENEULIN <contact@skypress.fr> 
 * 
 */
interface OrderInterface{

	/**
	 * @version 0.5
 	 * @since 0.5
 	 * @access public
 	 * @param int $int
 	 *
	 */
	public function setOrder($int);	

	/**
	 * @version 0.5
 	 * @since 0.5
 	 * @access public
 	 *
	 * @return int
	 */
	public function getOrder();	
}