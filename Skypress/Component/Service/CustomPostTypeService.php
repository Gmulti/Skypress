<?php

namespace Skypress\Component\Service;

use Skypress\Component\Models\HooksInterface;
use Skypress\Component\Models\Factory\CustomPostTypeFactoryInterface;
use Skypress\Component\Models\HelperConfigInterface;
use Skypress\Component\Models\ConfigInterface;





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
					$this->create($cpt['slug'], $cpt['args'], $cpt['labels']);
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
		public function create($slug, $args, $labels){
			$this->factory->create($slug, $args, $labels);
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

					if (!array_key_exists('slug', $cpt) || empty($cpt['slug'])):
						throw new \Exception("Your custom post type must have a slug");
					endif;

					if (!array_key_exists('args', $cpt)):
						$cpt['args'] = array();
					endif;

					if (!array_key_exists('labels', $cpt)):
						$cpt['labels'] = array();
					endif;

					array_push($this->cpts, $cpt);

				endforeach;

			endif;
		
			return $this;
		}

		public function setConfig($config){

			if (!array_key_exists('slug', $config) || empty($config['slug'])):
				throw new \Exception("Your custom post type must have a slug");
			endif;

			if (!array_key_exists('args', $config)):
				$config['args'] = array();
			endif;

			if (!array_key_exists('labels', $config)):
				$config['labels'] = array();
			endif;

			array_push($this->cpts, $config);

			return $this;
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

		public function addCustomPostType($config){
			$this->setConfig($config);
		}

	}
}
