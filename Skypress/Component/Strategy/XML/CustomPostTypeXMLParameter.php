<?php


namespace Skypress\Component\Strategy\XML;

use Skypress\Component\Models\Strategy\ServiceParameterInterface;
use Skypress\Component\Entity\CustomPostType;

if(!class_exists('CustomPostTypeXMLParameter')){
	/**
 	 *
	 * @version 0.6
	 * @since 0.6
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
	class CustomPostTypeXMLParameter extends XMLStrategy implements ServiceParameterInterface{

		/**
		 * @version 0.6
		 * @since 0.6
		 *
		 * @var array
		 * @access protected
		 */
		protected $cpts = array();

		/**
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public
		 * @param string $file
		 */
		public function __construct($file = null){
			parent::__construct($file);
		}

		/**
	 	 * Get service use for Custom post type parameter
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public
		 */
		public function getServiceParameter(){
			return apply_filters( 'get_service_parameter_cpt', 'CustomPostTypeFactoryService' );
		}

		/**
	 	 * Get custom post type from parameter file
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public
		 */
		public function getCustomPostTypes(){
			$this->crawler->filter('custom-post-type')->each(function($node,$i){

				$this->cpts[$i]['slug'] = $node->attr('slug');

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

					$this->cpts[$i]['args'][$keyName] = $array;
				});
			});

			return $this->cpts;
		}

		/**
	 	 * Check if exist configuration custom post type
	 	 *
		 * @version 0.6
		 * @since 0.6
		 * @access public
		 */
		public function exist(){
			try {
				$text = $this->crawler->filter('custom-post-type')->text();
				if(!empty($text)):
					return true;
				endif;
			} catch (\Exception $e) {
				return false;
			}
		}

		public function transformCustomPostTypesObject(array $cpts){

			$transform = array();

			foreach ($cpts as $key => $cpt):
				if('stdClass' === get_class($cpt)):
					$obj = new CustomPostType($key, $cpt);
					foreach ($obj->getArgs() as $key => $args):

					endforeach;
				endif;
			endforeach;

			return $transform;
		}
	}
}
