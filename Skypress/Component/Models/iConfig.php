<?php 

namespace Skypress\Component\Models;

/**
 *
 * @version 0.5
 * @since 0.5
 * 
 * @author Thomas DENEULIN <contact@skypress.fr> 
 * 
 */
interface iConfig{

	/**
	 * @version 0.5
 	 * @since 0.5
 	 * @access public
 	 * 
	 * @return array
	 */
	public function getConfig();

	/**
	 *
	 * @version 0.5
 	 * @since 0.5
 	 * @access public
 	 *
	 * @param array $config
	 */
	public function setConfig($config);	

}