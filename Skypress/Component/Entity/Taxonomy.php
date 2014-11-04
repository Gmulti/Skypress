<?php

namespace Skypress\Component\Entity;

use Skypress\Component\Entity\Term;



if ( ! class_exists( 'Taxonomy' ) ){

	/**
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 * 
	 * @since 0.5
	 * @version 0.5
	 */
	class Taxonomy  {

		/**
		 * Slug taxonomy
		 * 
		 * @var string
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
		 */
		private $slug 		= null;

		/**
		 * Custom post type associé
		 * 
		 * @var array
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
 		 * 
		 */
		private $post_type 	= array();

		/**
		 * Label for taxonomy
		 * 
		 * @var array
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
 		 * 
		 */
		private $labels 		= array();

		/**
		 * Args taxonomy
		 * 
		 * @var array
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
 		 * 
		 */
		private $args		= null;

		/**
		 * Terms taxonomy
		 * 
		 * @var array
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
 		 * 
		 */
		private $terms		= array();
		

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
		public function __construct($slug, $post_type, $args = array(), $labels = array(), $terms = array()){

			$this->setSlug( $slug );
			$this->setPostType( $post_type );
			$this->setLabels( $labels );
			$this->setArgs( $labels );
			$this->setTerms( $terms );

		}

		/**
		 * Set terms
		 * 
		 * @param arrahy $terms
		 *
		 * @access public
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setTerms($terms){
			
			foreach ($terms as $key => $term):
				$this->setTerm($term);
			endforeach;

			return $this;
		}

		/**
		 * Ajouter un term au tableau de terms
		 *
		 * @access public
		 * 
		 * @param string $term
		 * 
		 * @since 0.5
 		 * @version 0.5
		 */
		public function setTerm(Term $term){
			$this->term[$term->getSlug()] = $term;
			return $this;
		}

		/**
		 * Get all terms
		 *
		 * @access public
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 * @return array 
		 */
		public function getTerms(){
			return $this->terms;
		}

		/**
		 * Get a term
		 *
		 * @access public
		 * 
		 * @param  string $key 
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 * @return string      
		 */
		public function getTerm( $key){
			
			$term = null;

			if(array_key_exists($key, $this->terms)){
				$term = $this->terms[$key];
			}
			
			return $term;
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
			$this->slug = sanitize_key( $slug );
			return $this;
		}

		/**
		 * Set a post type support by taxonomy
		 *
		 * @access public
		 * 
		 * @param (string|array) $post_type
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setPostType( $post_type ) 
		{
			if(is_array($post_type)):
				foreach ($post_type as $key => $value) {
					$this->post_type[] = $value;
				}
			else:
				$this->post_type[] = $post_type;
			endif;
			
			return $this;
		}

		/**
		 * Set labels
		 *
		 * @access public
		 * 
		 * @param array $labels 
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setLabels($labels){

	    	 $singular   = ucwords( str_replace( '_', ' ', $this->getSlug() ) );  
	    	 $plural     = $singular . 's';
			  
			 // Default
		     $labels = array_merge(
			      array(  
			           'name'                  => $plural,  
			           'singular_name'         => $singular,  
			           'menu_name'             => $plural  
			       )
			       ,
			       $labels
			);

		    $this->labels = $labels;
			
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
		 */
		public function setArgs($args){

			$args = is_array( $args ) ? $args : array( $args );
			$args = array_merge(
				  array(
				    'hierarchical' => true,
					'labels' => $this->getLabels(),
				  )
				  ,
				  $args
			);

			$this->args = $args;
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
		 * Get labels
		 *
		 * @access public
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 * @return array
		 */
		public function getLabels(){
			return $this->labels;
		}

		/**
		 * Get post type
		 *
		 * @access public
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 * @return array
		 */
		public function getPostType(){
			return $this->post_type;
		}
	}
}
