<?php

namespace Skypress\Component\Service;

use Skypress\Component\Models\iHooks;
use Skypress\Component\Models\iTaxonomyFactory;
use Skypress\Component\Models\iHelperConfig;
use Skypress\Component\Models\iConfig;
use Skypress\Component\Models\iOrder;

use Skypress\Component\Service\CollegueService;




if(!class_exists('TermService')){

	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class TermService extends CollegueService implements iOrder, iHooks, iConfig, iHelperConfig {

		/**
		 * Liste des terms
		 *
		 * @var array
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $terms;


		/**
		 * Liste des objets terms
		 *
		 * @var array
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $termsObject;

		/**
		 * Factory de Terms
		 * 
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
		protected $order = 2;

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
		public function __construct($factory, $configService = array()) {
			$this->factory = $factory;
			$this->setConfig($configService);
			

		}


		/**
		 * @access public
		 * @version 0.5
 		 * @since 0.5
		 *
		 */
		public function hooks()
		{

	    	if(!$this->isEmptyConfig()):
				foreach ($this->terms as $key => $term):
					$args = (isset($term['args'])) ? $term['args'] : array();
					$this->create($term['slug'], $term['taxonomies'], $args);
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
		public function create($slug, $taxonomies, $args = array() ){

			$this->termsObject[$slug] = $this->factory->create($slug, $taxonomies, $args = array());
		}


		/**
		 * Get all objet terms
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
		public function getterms(){
			return $this->termsObject;
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
			if(array_key_exists($key, $config)):
				if($object):
					return $this->termsObject[$key];
				else:
					return $config[$key];
				endif;
			endif;

			return null;
		}

		/**
		 * Get all terms
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 *
		 * @return array
		 */
		public function getConfig(){
			return $this->terms;
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

				foreach ($config as $key => $term):

					if (!array_key_exists('slug', $term) || empty($term['slug'])):
						throw new \Exception("Votre term doit avoir un slug");
					endif;

					if (!array_key_exists('taxonomies', $term) || empty($term['taxonomies'])):
						throw new \Exception("Votre term doit avoir un tableau de taxonomy non vide");
					endif;

				endforeach;

			endif;

			$this->terms = $config;
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
		 *
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
