<?php

namespace Skypress\Component\Service\CustomPostTypes;

use Skypress\Component\Models\CustomPostTypeServiceInterface;
use Skypress\Component\Service\ColleagueService;
	
class ScrapperCustomPostType extends ColleagueService implements CustomPostTypeServiceInterface
{
	public function __construct(){

	}

	public function getCustomPostTypes($object = 0){
		$types = get_post_types();
		$postTypes = array();
		
		if($object):
			foreach ($types as $key => $type):
				$postTypes[$key] = get_post_type_object($type);
			endforeach;
		else:
			$postTypes = $types;
		endif;

		return $postTypes; 
	}

}