<?php 


namespace Skypress\Component\Models\Strategy;

/**
 *
 * @version 0.6
 * @since 0.6
 * 
 * @author Thomas DENEULIN <contact@skypress.fr> 
 * 
 */
interface ServiceParameterInterface{
	public function getServiceParameter();
	public function exist();
}