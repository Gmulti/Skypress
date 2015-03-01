<?php

namespace Skypress\Component\Entity;



if ( ! class_exists( 'CustomPostType' ) ){

	/**
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 * 
	 * @since 0.5
	 * @version 0.5
	 * 
	 */
	class CustomPostType {

		/**
		 * Slug custom post type
		 * 
		 * @var string
		 * @access private
		 * @since 0.5
 		 * @version 0.5
		 */
		private $slug 		= null;
		
		/**
		 * Args for custom post type
		 * 
		 * @var array
		 * @access private
		 * @since 0.5
 		 * @version 0.5
		 */
		private $args 		= array(); 


		/**
		 * Construct
		 *
		 * @access public
		 * 
		 * @param string $slug   
		 * @param array  $args   
		 * @param array  $labels
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function __construct( $slug, $args = array()){

			$this->setSlug( $slug );
			$this->setArgs( $args );


		}

		/**
		 * Set slug
		 * 
		 * @access public
		 * @param string $slug
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setSlug( $slug ) 
		{
			$this->slug = sanitize_key( $slug );
		}
		

		/**
		 * Set args
		 *
		 * @access public
		 * @param array $args
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setArgs( $args ) 
		{
			
			$args = is_array( $args ) ? $args : (array)$args;
			
			if(array_key_exists('labels', $args)):
				// Transform labels class in array
				if(is_object($args['labels'])):
					$args['labels'] = (array) $args['labels'];
				endif;
			else:
				$args['labels'] = array();
			endif;
			
			if(array_key_exists('cap', $args)):
				// Transform cap class in array
				if(is_object($args['cap'])):
					$args['cap'] = (array) $args['cap'];
				endif;
			endif;

			$name   = ucwords( preg_replace( '#([_-])#', ' ', $this->getSlug() ) );  

			$this->args['labels'] = array_merge(
			    array(  
			       'name'                  => $name,  
		           'singular_name'         => $name,  
		           'menu_name'             => $name  
		        )
			    ,
			    $args['labels']
			);

			$this->args = array_merge(
				  array(
				    'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_admin_bar'   => true,
				    'has_archive' 	=> true, 
				    'supports' 		=> array('title','editor')
				  )
				  ,
				  $args
			);


			return $this;
		}
		
		
		/**
		 * Get slug
		 *
		 * @access public
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

	}
}
