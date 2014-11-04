<?php 


namespace Skypress\Component\Models;

/**
 * Si l'on implémente cette interface, cela permet à celle-ci d'être accessible par le mediator correspondant
 *
 * Exemple : Si un service doit être accessible par le ServiceMediator.
 * 
 * @version 0.5
 * @since 0.5
 * 
 * @author Thomas DENEULIN <contact@skypress.fr> 
 * 
 */
interface iCollegue{
	public function getMediator();
	public function setMediator(iMediator $mediator);
}