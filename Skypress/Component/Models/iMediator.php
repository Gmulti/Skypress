<?php 


namespace Skypress\Component\Models;

/**
 *
 * Interface d'un mediator
 * 
 * @version 0.5
 * @since 0.5
 * 
 * @author Thomas DENEULIN <contact@skypress.fr> 
 * 
 */
interface iMediator{
	public function getCollegues();	
	public function setCollegues($collegues);	
	public function getCollegue($key);	
	public function setCollegue($collegue);	
}