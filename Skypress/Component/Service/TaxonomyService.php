<?php

namespace Skypress\Component\Service;

use Skypress\Component\Models\iHooks;
use Skypress\Component\Models\iTaxonomyFactory;
use Skypress\Component\Models\iHelperConfig;
use Skypress\Component\Models\iConfig;
use Skypress\Component\Models\iOrder;

use Skypress\Component\Service\CollegueService;




if(!class_exists('TaxonomyService')){

	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class TaxonomyService extends CollegueService implements iOrder, iHooks, iConfig, iHelperConfig {

		/**
		 * Liste des taxos
		 *
		 * @var array
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $taxonomies;


		/**
		 * Liste des objets taxos
		 *
		 * @var array
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $taxonomiesObject;

		/**
		 * Factory de Taxo
		 * @var iTaxonomyFactory
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $factory;

		/**
		 * 
		 * @version 0.5
 		 * @since 0.5
 		 * @access protected
 		 * 
		 * @var integer
		 */
		protected $order = 1;


		/**
		 * Construct
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @param array           $configService
		 * @param iTaxonomyFactory $factory
		 */
		public function __construct($configService, $factory) {

			$this->setConfig($configService);
			$this->factory = $factory;

		}


		/**
		 * Implements iHooks
		 * 
		 * @access public
		 * @version 0.5
 		 * @since 0.5
		 *
		 */
		public function hooks()
		{

	    	if(!$this->isEmptyConfig()):
				foreach ($this->taxonomies as $key => $taxo):
					$this->create($taxo['slug'], $taxo['post_type'], $taxo['args'], $taxo['labels']);
				endforeach;
			endif;
		}

		/**
		 * Appelle la factory de taxo
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
		public function create($slug, $post_type, $args, $labels, $terms = array() ){

			$this->taxonomiesObject[$slug] = $this->factory->create($slug, $post_type, $args, $labels, $terms);
		}


		/**
		 * Get all objet taxonomies
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @param string $key  Slug taxonomy
		 * @param boolean $object  type return
		 *
		 * @return (array|Taxonomy)
		 */
		public function getTaxonomies(){
			return $this->taxonomiesObject;
		}

		/**
		 * Get taxonomy by key
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @param string $key  Slug taxonomy
		 * @param boolean $object  type return
		 *
		 * @return (array|Taxonomy)
		 */
		public function getTaxonomy($key, $object = false){
			$config =  $this->getConfig();

			foreach($config as $key_config => $value_config):
				if($key == $value_config['slug']):
					if($object):
						return $this->taxonomiesObject[$key];
					else:
						return $config[$key_config];
					endif;
				endif;
			endforeach;
			

			return null;
		}

		/**
		 * Get all Taxonomies
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @return array
		 */
		public function getConfig(){
			return $this->taxonomies;
		}

		/**
		 * Set config taxo
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
						throw new \Exception("Votre taxonomy doit avoir un slug");
					endif;

					if (!array_key_exists('post_type', $cpt) || empty($cpt['post_type'])):
						throw new \Exception("Votre taxonomy doit avoir un tableau de post type.");
					endif;

					if (!array_key_exists('args', $cpt)):
						$cpt['args'] = array();
					endif;

					if (!array_key_exists('labels', $cpt)):
						$cpt['labels'] = array();
					endif;

				endforeach;

			endif;

			$this->taxonomies = $config;
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
			return ( empty( $config) ) ? true : false;
		}

		/**
		 * Implements iOrder
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 * 
		 * @return int 
		 */
		public function getOrder(){
			return $this->order;
		}

		/**
		 * Implements iOrder
		 * 
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 * 
		 * @param int $order 
		 */
		public function setOrder($order){
			if(is_int($order)):
				$this->order = $order;
			else:
				throw new Exception("Le paramètre order doit être un integer");
			endif;

			
			return $this;
		}
	}
}
