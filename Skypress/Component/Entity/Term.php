<?php

namespace Skypress\Component\Entity;


use Skypress\Component\Entity\Taxonomy;
use Skypress\Component\Service\MediatorService;



if ( ! class_exists( 'Term' ) ){

	/**
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 * 
	 * @since 0.5
	 * @version 0.5
	 */
	class Term  {

		/**
		 * Slug term
		 * 
		 * @var string
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
		 */
		private $slug 		= null;

		/**
		 * Name term
		 * 
		 * @var string
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
		 */
		private $name 		= null;

		/**
		 * Taxonomies associées
		 * 
		 * @var array
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
 		 * 
		 */
		private $taxonomies 	= array();

		/**
		 * Custom post type associé
		 * 
		 * @var array
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
 		 * 
		 */
		private $args 	= array();
		

		/**
		 * Construct
		 * 
		 * @param string $slug      
		 * @param array $post_type 
		 * @param array  $labels    
		 * @param array  $args      
		 * @param array  $terms
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 *
 		 * @access public
 		 * 
		 */
		public function __construct($slug, $taxonomies, $args = array()){

			$this->setSlug( $slug );
			$this->setTaxonomies( $taxonomies );
			$this->setArgs( $args );

		}


		/**
		 * Set slug
		 *
		 * @access public
		 * 
		 * @param string $slug
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setSlug( $slug ) 
		{
			$this->slug = sanitize_title( $slug );
			$this->setName($slug);

			return $this;
		}

		public function setName($name){
			$this->name = ucwords(strtolower($name));
			return $this;
		}

		/**
		 * Set args
		 *
		 * @access public
		 * 
		 * @param array $args
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setArgs( $args ) 
		{
			foreach ($args as $key => $value):
				
				$autorisation = apply_filters( 'autorisation_term_args', array('description','slug','parent') );

				if(!in_array($key, $autorisation)):
					unset($args[$key]);
				endif;
			endforeach;

			$this->args = $args;

			return $this;
		}

		/**
		 * Set args
		 *
		 * @access public
		 * 
		 * @param array $taxonomies
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setTaxonomies($taxonomies){

			$service_taxo = MediatorService::getMediator('ServiceContainer')->getColleague('TaxonomyService');

			if(is_array($taxonomies)):
				foreach ($taxonomies as $key => $taxonomy):
					
					$taxo = $service_taxo->getTaxonomy($taxonomy, true);

					if($taxo instanceOf Taxonomy):
			
						$this->setTaxonomy($taxo);

					endif;
					
				endforeach;
			else:
				
				$taxo = $service_taxo->getTaxonomy($taxonomies, true);

				if($taxo instanceOf Taxonomy):
					$this->setTaxonomy($taxo);
				endif;
			endif;
		}

		/**
		 * Set taxonomy
		 *
		 * @access public
		 * 
		 * @param (array|string) $args
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setTaxonomy(Taxonomy $taxonomy ) 
		{

			$this->taxonomies[$taxonomy->getSlug()] = $taxonomy;

			return $this;
		}

		/**
		 * Get name
		 *
		 * @access public
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 *
 		 * @return string
 		 * 
		 */
		public function getName(){
			return $this->name;
		}

		/**
		 * Get Slug
		 *
		 * @access public
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 * @return string
		 */
		public function getSlug(){
			return $this->slug;
		}

		/**
		 * Get args
		 *
		 * @access public
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 * @return array
		 */
		public function getArgs(){
			return $this->args;
		}


		/**
		 * Get taxonomies
		 *
		 * @access public
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 * @return array
		 */
		public function getTaxonomies(){
			return $this->taxonomies;
		}
	}
}
