<?php

namespace Skypress\Component\Service;

use Skypress\Component\Models\HooksInterface;
use Skypress\Component\Models\Factory\CustomPostTypeFactoryInterface;
use Skypress\Component\Models\HelperConfigInterface;
use Skypress\Component\Models\ConfigInterface;

use Skypress\Component\Entity\CustomPostType;





if(!class_exists('CustomPostTypeService')){
	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class CustomPostTypeService implements HooksInterface, ConfigInterface, HelperConfigInterface {

		/**
		 * Liste des CPTS
		 *
		 * @var array
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $cpts = array();

		/**
		 * Factory de CPT
		 * @var CustomPostTypeFactoryInterface
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $factory;

		/**
		 * Construct
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @param array                  $configService
		 * @param CustomPostTypeFactoryInterface $factory
		 */
		public function __construct(CustomPostTypeFactoryInterface $factory, $configService = array()){
		
			if(!empty($configService)):
				$this->setConfigs($configService);
			endif;

			$this->factory = $factory;

		}

		/**
		 * Implements HooksInterface
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @return void
		 */
		public function hooks(){


			if(!$this->isEmptyConfig()):
				foreach ($this->cpts as $key => $cpt) {
					if ($cpt instanceOf CustomPostType):
						$this->createFromCustomPostType($cpt);
					else:
						$this->create($cpt['slug'], $cpt['args']);
					endif;
				}
			endif;

		}

		/**
		 * Appelle la factory de CPT
		 *
		 * @param  string $slug
		 * @param  array $args
		 * @param  array $labels
		 *
		 * @access public
		 * @version 0.5
		 * @since 0.5
		 *
		 * @return void
		 */
		public function create($slug, $args){
			$this->factory->create($slug, $args);
		}

		public function createFromCustomPostType(CustomPostType $cpt){
			$this->factory->registerPostType($cpt);
		}

		/**
		 * Delete CPT
		 *
		 * @param  $slug
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @return void
		 */
		public function delete($slug){

		}

		/**
		 * Get all CPTS
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @return array
		 */
		public function getConfig(){
			return $this->cpts;
		}

		/**
		 * Set CPTS
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @param array $config
		 */
		public function setConfigs($config){

			if(!empty($config) && is_array($config)):

				foreach ($config as $key => $cpt):

					if (!$cpt instanceOf CustomPostType):
						$cpt = $this->checkConfig($cpt);
					endif;

					array_push($this->cpts, $cpt);

				endforeach;
			endif;
		
			return $this;
		}

		/**
		 * Set config cpt
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @param (array|CustomPostType) $config
		 */
		public function setConfig($config){

			if(!empty($config) && is_array($config)):
				$config = $this->checkConfig($config);
			endif;

			array_push($this->cpts, $config);

			return $this;
		}

		/**
		 * Set one config taxo
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @param array $config
		 */
		public function checkConfig($config){
			if (!array_key_exists('slug', $config) || empty($config['slug'])):
				throw new \Exception("Your custom post type must have a slug");
			endif;

			if (!array_key_exists('args', $config)):
				$config['args'] = array();
			endif;

			if (!array_key_exists('labels', $config)):
				$config['labels'] = array();
			endif;

			return $config;
		}


		/**
		 * Helper
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @return boolean Return true or false if is empty config
		 */
		public function isEmptyConfig(){
			$config = $this->getConfig(); 
			return ( empty($config) ) ? true : false;
		}

		public function addCustomPostType(CustomPostType $config){
			$this->setConfig($config);
		}

		public function addCustomPostTypes($config){
			if(is_array($config)):
				$this->setConfigs($config);
			endif;
		}

	}
}
