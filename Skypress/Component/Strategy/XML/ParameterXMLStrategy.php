<?php 


namespace Skypress\Component\Strategy\XML;


if(!class_exists('ParameterXMLStrategy')){
	/**
 	 *
	 * @version 0.6
	 * @since 0.6
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class ParameterXMLStrategy extends XMLStrategy{

		protected $parameter;

		public function getParameter($key){
			
			$this->crawler->filter('parameter')->each(function($node, $i) use ($key){

				if ($node->attr('key') == $key):

					$this->parameter = $node->text();
				endif;
				
			});
			
			return $this->parameter;
		}

	}
}
