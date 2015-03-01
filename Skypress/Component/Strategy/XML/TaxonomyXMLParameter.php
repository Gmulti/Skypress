<?php 

namespace Skypress\Component\Strategy\XML;

use Skypress\Component\Models\Strategy\ServiceParameterInterface;

if(!class_exists('TaxonomyXMLParameter')){
	/**
 	 *
	 * @version 0.6
	 * @since 0.6
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class TaxonomyXMLParameter extends XMLStrategy implements ServiceParameterInterface {
		
		/**
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access protected
		 * @var array
		 * 
		 */
		protected $taxonomies = array();

		/**
	 	 * 
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public
		 * @param string $file
		 * 
		 */
		public function __construct($file = null){
			parent::__construct($file);
		}

		/**
	 	 * Get service use for Taxonomy parameter
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function getServiceParameter(){
			return apply_filters( 'get_service_parameter_taxonomy', 'TaxonomyService' );
		}

		/**
	 	 * Get taxonomies from parameter file
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function getTaxonomies(){
			
			$this->crawler->filter('taxonomy')->each(function($node,$i){
		
				$this->taxonomies[$i]['slug'] = $node->attr('slug');
				$postTypes = $node->attr('post-types');
				$delimiter = apply_filters( 'delimiter_post_types_taxonomy', ',' );

				$this->taxonomies[$i]['post_type'] = explode($delimiter, $postTypes);

				$node->children()->each(function($nodeChildren, $y) use($i){
					$type = $nodeChildren->attr('type');
					$keyName = $nodeChildren->current()->nodeName;
					$array = array();
					
					if ($type == 'collection') {
						foreach ($nodeChildren->children() as $key => $value) {
							$array[] = $value->nodeValue;
						}
					}
					else{
						foreach ($nodeChildren->children() as $key => $value) {
							$array[$value->nodeName] = $value->nodeValue;
						}
					}

					$this->taxonomies[$i]['args'][$keyName] = $array;
				});
			});

			return $this->taxonomies;
		}

		/**
	 	 * Check if exist configuration taxonomy
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public 
		 */
		public function exist(){
			try {
				$text = $this->crawler->filter('taxonomy')->text();
				if(!empty($text)):
					return true;
				endif;
			} catch (\Exception $e) {
				return false;
			}
		}
	}
}
