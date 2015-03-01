<?php

namespace Skypress\Component\Service;

use Skypress\Component\Models\HooksInterface;
use Skypress\Component\Models\Factory\TaxonomyFactoryInterface;
use Skypress\Component\Models\HelperConfigInterface;
use Skypress\Component\Models\ConfigInterface;
use Skypress\Component\Models\OrderInterface;
use Skypress\Component\Entity\Taxonomy;

use Skypress\Component\Service\ColleagueService;




if(!class_exists('TaxonomyService')){

	/**
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class TaxonomyService extends ColleagueService implements OrderInterface, HooksInterface, ConfigInterface, HelperConfigInterface {

		/**
		 * Liste des taxos
		 *
		 * @var array
		 * @version 0.5
		 * @since 0.5
		 * @access protected
		 *
		 */
		protected $taxonomies = array();


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
		 * @var TaxonomyFactoryInterface
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
		 * @param TaxonomyFactoryInterface $factory
		 */
		public function __construct(TaxonomyFactoryInterface $factory, $configService = array()) {

			if(!empty($configService)):
				$this->setConfigs($configService);
			endif;

			$this->factory = $factory;

		}


		/**
		 * Implements HooksInterface
		 * 
		 * @access public
		 * @version 0.5
 		 * @since 0.5
		 *
		 */
		public function hooks()
		{

			$this->setConfigsParameters();

	    	if(!$this->isEmptyConfig()):
				foreach ($this->taxonomies as $key => $taxo):
					if($taxo instanceOf Taxonomy):
						$this->createFromTaxonomy($taxo);
					else:
						$this->create($taxo['slug'], $taxo['post_type'], $taxo['args']);
					endif;
				endforeach;
			endif;

			return $this;
		}

		/**
		 * Set Taxonomies by Parameters file
		 *
		 * @version 0.6
		 * @since 0.6
		 * @access private
		 *
		 */
		private function setConfigsParameters(){
			$taxonomies = $this->getService('ParameterService')->getTaxonomies();

			foreach ($taxonomies as $key => $taxonomy):
				$this->setConfig($taxonomy);
			endforeach;

		}

		/**
		 * Appelle la factory de taxo
		 *
		 * @param  string $slug
		 * @param  array $args
		 *
		 * @access public
		 * @version 0.5
		 * @since 0.5
		 *
		 * @return void
		 */
		public function create($slug, $post_type, $args, $terms = array() ){

			$this->taxonomiesObject[$slug] = $this->factory->create($slug, $post_type, $args, $terms);
		}

		public function createFromTaxonomy($taxo){
			$this->factory->addTaxonomy($taxo);
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
		public function setConfigs($config){

			if(!empty($config) && is_array($config)):

				foreach ($config as $key => $taxo):

					if (!$taxo instanceOf Taxonomy):
						$taxo = $this->checkConfig($taxo);
					endif;

					array_push($this->taxonomies, $taxo);

				endforeach;

			endif;

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
		public function setConfig($config){

			if(!empty($config) && is_array($config)):
				$config = $this->checkConfig($config);
			endif;

			array_push($this->taxonomies, $config);

			return $this;
		}

		

		/**
		 * Check config
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 * 
		 * @param  array $config 
		 * 
		 * @return array        
		 */
		public function checkConfig($config){

			if (!array_key_exists('slug', $config) || empty($config['slug'])):
				throw new \Exception("Your custom post type must have a slug");
			endif;

			if (!array_key_exists('post_type', $config) || empty($config['post_type'])):
				throw new \Exception("Your taxonomy should have an array of post types.");
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
			return ( empty( $config) ) ? true : false;
		}

		/**
		 * Implements OrderInterface
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
		 * Implements OrderInterface
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
				throw new Exception("The parameter must be an integer");
			endif;

			
			return $this;
		}

		/**
		 * Add Taxonomy with setConfig
		 *
		 * @version 0.5
		 * @since 0.5
		 * @access public
		 * 
		 * @param array $config
		 * 
		 */
		public function addTaxonomy(Taxonomy $config){
			$this->setConfig($config);
		}

		public function addTaxonomies($config){
			if(is_array($config)):
				$this->setConfigs($config);
			endif;
		}
	}
}

