<?php

namespace Skypress\Component\Factory;

use Skypress\Component\Entity\CustomPostType;
use Skypress\Component\Models\iCustomPostType;
use Skypress\Component\Models\HooksInterface;
use Skypress\Component\Models\Factory\CustomPostTypeFactoryInterface;


if ( ! class_exists( 'CustomPostTypeFactory' ) ){

	/**
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 * @since 0.5
	 * @version 0.5
	 */
	class CustomPostTypeFactory implements CustomPostTypeFactoryInterface {

		/**
		 * Create custom post type
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * @access public
 		 *
		 * @param  string $slug
		 * @param  array  $args
		 * @param  array  $labels
		 *
		 * @return void
		 */
		public function create($slug, $args = array())
		{
			$cpt = new CustomPostType($slug, $args);
			$this->registerPostType($cpt);
		}


		/**
		 * Register a custom post type on init action
		 *
		 * @param  CustomPostTypeInterface $cpt
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * @access public
 		 *
		 * @return void
		 */
		public function registerPostType(CustomPostType $cpt){

			if( !post_type_exists( $cpt->getSlug() ) ) {

				$args = $cpt->getArgs();
		  		$slug = $cpt->getSlug();

				if(in_array('thumbnail', $args['supports'])):
					add_action('after_setup_theme',function() use($slug, $args){
						add_theme_support( 'post-thumbnails', array( $slug ) );
					});
		  		endif;

				add_action('init', function() use( $slug, $args ) {
				 	register_post_type( $slug, $args );
				});
			}
		}

	}
}
