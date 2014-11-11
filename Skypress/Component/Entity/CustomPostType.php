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
		 * Labels for custom post type
		 * 
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
		 * @var array
		 */
		private $labels 		= array();

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
		public function __construct( $slug, $args = array(), $labels = array()){

			$this->setSlug( $slug );
			$this->setLabels( $slug, (array)$labels );
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
		 * Set labels
		 *
		 * @access public
		 * @param string $slug   
		 * @param array  $labels 
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * 
		 */
		public function setLabels( $slug, $labels = array() ) 
		{
			  
	    	$name   = ucwords( preg_replace( '#([_-])#', ' ', $slug ) );  
			  
		    $this->labels = array_merge(
			    array(  
			       'name'                  => $name,  
		           'singular_name'         => $name,  
		           'menu_name'             => $name  
		        )
			    ,
			    $labels
			);
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
			$this->args = array_merge(
				  array(
				    'labels' 		=> $this->labels,
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
			return $this->label;
		}

	}
}
