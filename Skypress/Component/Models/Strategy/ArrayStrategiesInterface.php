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
interface ArrayStrategiesInterface{
	public function getStrategy($key);
	public function setStrategy($key, StrategyInterface $strategy);
	
}
