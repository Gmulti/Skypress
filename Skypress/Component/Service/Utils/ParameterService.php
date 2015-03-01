<?php 

namespace Skypress\Component\Service\Utils;

use Skypress\KernelSkypress;
use Skypress\Component\Models\ColleagueInterface;
use Skypress\Component\Models\MediatorInterface;
use Skypress\Component\Models\Strategy\StrategyInterface;
use Skypress\Component\Models\Strategy\ParameterInterface;
use Skypress\Component\Models\Strategy\XMLInterface;
use Skypress\Component\Models\Strategy\ArrayStrategiesInterface;
use Skypress\Component\Models\Strategy\ServiceParameterInterface;
use Skypress\Component\Models\Strategy\HooksInterface;

if(!class_exists('ParameterService')):

	
	/**
	 *
	 * @version 0.6
	 * @since 0.6
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class ParameterService implements ArrayStrategiesInterface {

		/**
		 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access protected
		 * @var string
		 *
		 */
		protected $fileExt;

		/**
		 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access protected
		 * @var string
		 */
		protected $fileDefault;

		/**
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 * @param array $strategies
		 */
		public function __construct(array $strategies = array()){

			// Construct default parameters
			$this->fileDefault = WPMU_PLUGIN_DIR . '/Skypress/parameters.xml';		

			// Construct parameters externaly
			$this->constructFileExt();

			// Construct strategies treatment
			foreach ($strategies as $key => $strategy):
				if ($strategy instanceOf ParameterInterface):
					$classname = get_class($strategy);

					if (preg_match('@\\\\([\w]+)$@', $classname, $matches)):
				        $classname = $matches[1];

				    	if($strategy instanceOf XMLInterface):
				    		$strategy = $this->addFileOnStrategyXML($strategy,$classname);
				    	endif;
						$this->strategies[$classname] = $strategy;
					endif;

				endif;	
			endforeach;
			

		}


		/**
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 */
		public function hooks(){
			
		}

		/**
	 	 * Get file extern
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 *
		 */
		public function getFileExt(){

			return $this->fileExt;
		}

		/**
	 	 * Get file parameter default for Skypress
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function getFileDefault(){
			return $this->fileDefault;
		}

		/**
	 	 * Add file for a strategy 
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access private 
		 * @param XMLInterface $strategy
		 * @param string $classname
		 *
		 */
		private function addFileOnStrategyXML(XMLInterface $strategy, $classname){
			
			switch ($classname) {
				case 'CustomPostTypeXMLParameter':
					$strategy->addFile($this->getFileExt());
					break;

				case 'TaxonomyXMLParameter':
					$strategy->addFile($this->getFileExt());
					break;
				
				case 'XMLStrategy':
					$strategy->addFile($this->getFileDefault());
					break;

				default:
					$fileExt = apply_filters( 'file_default_parameter', $this->getFileExt() );
					$strategy->addFile($fileExt);
					break;
			}

			return $strategy;
		}


		/**
	 	 * Construct file extern
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access private 
		 */
		private function constructFileExt(){

			switch (KernelSkypress::getTypeFilter()) {
				case 'theme':

					if(file_exists(DIR_THEME_SP . '/src/app/config/parameters.xml')):
						$this->fileExt = DIR_THEME_SP . '/src/app/config/parameters.xml';

					endif;
					break;
				
				default:
					if(file_exists(WP_PLUGIN_DIR . '/' . KernelSkypress::getTypeFilter() . '/app/config/parameters.xml')):
						$this->fileExt = WP_PLUGIN_DIR . '/' . KernelSkypress::getTypeFilter() . '/app/config/parameters.xml';
					endif;
					break;
			}

		}

		/**
	 	 * Get custom post types from parameter file
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function getCustomPostTypes(){

			$cptStrat = $this->getStrategy('CustomPostTypeXMLParameter');
			if($cptStrat !== null):
				return $cptStrat->getCustomPostTypes();
			endif;
		}

		/**
	 	 * Get taxonomies from parameter file
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function getTaxonomies(){
			$taxonomyStrat = $this->getStrategy('TaxonomyXMLParameter');
			if($taxonomyStrat !== null):
				return $taxonomyStrat->getTaxonomies();
			endif;
		}

		/**
	 	 * Get a parameter
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 * @param string $key
		 */
		public function getParameter($key){
		
			$paramXMLStrat = $this->getStrategy('ParameterXMLStrategy');

			if($paramXMLStrat !== null):
				return $paramXMLStrat->getParameter($key);
			endif;

			return null;
		}

		/**
	 	 * Get strategy
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 * @param string $key
		 */
		public function getStrategy($key){
			if(array_key_exists($key, $this->strategies)):
				return $this->strategies[$key];
			endif;

			return null;

		}

		/**
	 	 * Get all strategies
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function getStrategies(){
			return $this->strategies;
		}

		/**
	 	 * Set a strategy
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function setStrategy($key, StrategyInterface $strategy){
			$this->strategies[$key] = $strategy;
		}

		/**
	 	 * Check config for all strategies and return services
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function getServicesCheckConfig(){
			
			$services = array();
			if($this->getFileExt() !== null):
				foreach ($this->getStrategies() as $key => $strategy):
					if($strategy instanceOf ServiceParameterInterface && $strategy->exist()):
						$services[] = $strategy->getServiceParameter();
					endif;
				endforeach;
			endif;

			return $services;
		}
		

	}


endif;