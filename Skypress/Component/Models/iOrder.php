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
interface iOrder{
	public function setOrder($int);	
	public function getOrder();	
}