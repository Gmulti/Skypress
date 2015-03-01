<?php 


namespace Skypress\PluginSkeleton\Models;


use Skypress\Component\Project\MainPlugin;

/**
 * 
 * @version 1.0
 * @since 1.0
 * 
 * @author Thomas DENEULIN <contact@skypress.fr> 
 * 
 */
interface PluginMediatorInterface{
	public function getPlugin();
	public function setPlugin(MainPlugin $mainPlugin);
}
