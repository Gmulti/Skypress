<?php

namespace Skypress\Component\Factory;

use Skypress\Component\Entity\Taxonomy;
use Skypress\Component\Models\iTaxonomyFactory;



if ( ! class_exists( 'TaxonomyFactory' ) ){

	/**
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 * @since 0.5
	 * @version 0.5
	 */
	class TaxonomyFactory {


		/**
		 * Create a taxonomy
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 *
		 * @param  String $slug
		 * @param  array $post_type
		 * @param  array  $labels
		 * @param  array  $args
		 * @param  array  $terms
		 *
		 * @return taxonomy
		 */
		public function create( $slug, $post_type, $args = array(), $labels = array(), $terms = array() ){

			$taxonomy = new Taxonomy($slug, $post_type, $args, $labels, $terms);

			$this->addTaxonomy($taxonomy);

			return $taxonomy;
		}

		/**
		 * Add taxonomy
		 *
		 * @param Taxonomy $taxonomy
		 * @since 0.5
		 * @version 0.5
		 * @access public
		 */
		public function addTaxonomy(Taxonomy $taxonomy) {
			add_action('init',
					   function () use( $taxonomy ) {
						   $this->registerTaxonomy($taxonomy);
					   }
				);
		}

		/**
		 * Register taxonomy
		 *
		 * @param  Taxonomy $taxonomy
		 * @since 0.5
		 * @version 0.5
		 * @access private
		 *
		 * @return void
		 */
		private function registerTaxonomy(Taxonomy $taxonomy){


			if(!taxonomy_exists( $taxonomy->getSlug() )){
				register_taxonomy( $taxonomy->getSlug(),  $taxonomy->getPostType(), $taxonomy->getArgs() );
			}
			else {
		        register_taxonomy_for_object_type( $taxonomy->getSlug(), $taxonomy->getPostType() );
			}

		}

		
	}
}
