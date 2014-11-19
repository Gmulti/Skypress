<?php 

namespace Skypress\Component\Service\Utils;

use Skypress\Component\Models\ColleagueInterface;
use Skypress\Component\Models\MediatorInterface;

if(!class_exists('ParameterService')):

	
	/**
	 *
	 * @version 0.6
	 * @since 0.6
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class ParameterService {

		protected $parameters;

		public function __construct(){
			if(file_exists(DIR_THEME_SP . '/src/app/parameters.xml')):
				$xml = (array)simplexml_load_file(DIR_THEME_SP . '/src/app/parameters.xml');
			endif;
			$parametersDefault = (array)simplexml_load_file(WPMU_PLUGIN_DIR . '/Skypress/parameters.xml');

			$this->parameters = array_merge($parametersDefault, $xml);
		}

		public function getParameter($key){
			if(array_key_exists($key, $this->parameters)):
				return $this->parameters[$key];
			endif;

			return null;
		}
		

	}


endif;