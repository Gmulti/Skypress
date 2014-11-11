<?php

namespace Skypress\Component\Factory;

use Skypress\Component\Entity\Term;
use Skypress\Component\Models\OrderInterface;
use Skypress\Component\Models\Factory\TermFactoryInterface;



if ( ! class_exists( 'TermFactory' ) ){

	/**
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 * @since 0.5
	 * @version 0.5
	 */
	class TermFactory implements TermFactoryInterface{


		/**
		 * Create term
		 * 
		 * @param  string $term     Name term
		 * @param  taxonomy $taxonomy Name taxonomy
		 * @param  array  $args   
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access public 
		 * 
		 * @return void           
		 */
		public function create( $term, $taxonomy, $args = array()){

			$term = new Term($term, $taxonomy, $args);

			$this->createTerm($term);

			return $term;
		}

		/**
		 * Create a term on action init WP
		 * 
		 * @param  Term   $term  Object term
		 *
		 * @since 0.5
		 * @version 0.5
		 * @access private 
		 * 
		 * @return void
		 */
		private function createTerm(Term $term){

			$taxos = $term->getTaxonomies();		

			if(!empty($taxos) && is_array($taxos)):
				foreach ($taxos as $key => $taxo):
					add_action('init',
						   function () use($taxo, $term) {
						   	   wp_insert_term( $term->getName(), $taxo->getSlug(), $term->getArgs());
						   }
					);

				endforeach;
			endif;
		}


	}
}
