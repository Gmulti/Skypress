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
		public function create($slug, $args = array(), $labels = array())
		{
			$cpt = new CustomPostType($slug, $args, $labels);
			$this->registerPostType($cpt);
		}


		/**
		 * Register a custom post type on init action
		 *
		 * @param  iCustomPostType $cpt
		 *
		 * @since 0.5
 		 * @version 0.5
 		 * @access private
 		 *
		 * @return void
		 */
		private function registerPostType($cpt){

			if( !post_type_exists( $cpt->getSlug() ) ) {

				add_action('init', function() use( $cpt ) {

			  		$slug = $cpt->getSlug();
			  		$args = $cpt->getArgs();

				 	register_post_type( $slug, $args );

				});
			}
		}

	}
}
