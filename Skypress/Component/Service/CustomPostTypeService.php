<?php

namespace Skypress\Component\Service;

use Skypress\Component\Models\iHooks;
use Skypress\Component\Models\iCustomPostTypeFactory;
use Skypress\Component\Models\iHelperConfig;
use Skypress\Component\Models\iConfig;




if(!class_exists('CustomPostTypeService')){
	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class CustomPostTypeService implements iHooks, iConfig, iHelperConfig {

		/**
		 * Liste des CPTS
		 *
		 * @var array
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $cpts;

		/**
		 * Factory de CPT
		 * @var iCustomPostTypeFactory
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
		 * @param iCustomPostTypeFactory $factory
		 */
		public function __construct($configService, $factory){

			$this->setConfig($configService);
			$this->factory = $factory;

		}

		/**
		 * Implements iHooks
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
		public function setConfig($config){

			if(!empty($config) && is_array($config)):

				foreach ($config as $key => $cpt):

					if (!array_key_exists('slug', $cpt) || empty($cpt['slug'])):
						throw new \Exception("Votre custom post type doit avoir un slug");
					endif;

					if (!array_key_exists('args', $cpt)):
						$cpt['args'] = array();
					endif;

					if (!array_key_exists('labels', $cpt)):
						$cpt['labels'] = array();
					endif;

				endforeach;

			endif;

			$this->cpts = $config;
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

	}
}
