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
		private $postType 	= array();


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
		 * @param array $postType 
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
		public function __construct($slug, $postType, $args = array(),  $terms = array()){

			$this->setSlug( $slug );
			$this->setPostType( $postType );
			$this->setArgs( $args );
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
		 * @param (string|array) $postType
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setPostType( $postType ) 
		{
			if(is_array($postType)):
				foreach ($postType as $key => $value) {
					$this->postType[] = $value;
				}
			else:
				$this->postType[] = $postType;
			endif;
			
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
		 */
		public function setArgs($args){

			$args = is_array( $args ) ? $args : array( $args );
			$args['labels'] = (array_key_exists('labels', $args) && is_array( $args['labels'] ) )? $args['labels'] : $args['labels'] = array();

			$name   = ucwords( str_replace( '_', ' ', $this->getSlug() ) );  
			
			$args['labels'] = array_merge(
			      array(  
			           'name'                  => $name,  
			           'singular_name'         => $name,  
			           'menu_name'             => $name  
			       )
			       ,
			       $args['labels']
			);

			$args = array_merge(
				  array(
				    'hierarchical' => true,
				  )
				  ,
				  $args
			);

			$this->args = $args;

			return $this;
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
			return $this->args['labels'];
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
			return $this->postType;
		}
	}
}
