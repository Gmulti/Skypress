<?php 


namespace Skypress\Component\Strategy\XML;

use Symfony\Component\DomCrawler\Crawler;
use Skypress\Component\Models\Strategy\XMLInterface;

if(!class_exists('XMLStrategy')){
	/**
 	 *
	 * @version 0.6
	 * @since 0.6
	 * 
	 * @author Thomas DENEULIN <contact@skypress.fr> 
	 * 
	 */
	class XMLStrategy extends ParameterStrategy implements XMLInterface{

		/**
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 * @var Symfony\Component\DomCrawler\Crawler
		 */
		protected $crawler;

		/**
		 * If a file exist, construc crawler
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 * @param string $file
		 */
		public function __construct($file = null){
			parent::__construct($file);

			$this->crawler = new Crawler();

			if($file !== null):
				$this->crawlFile();
			endif;
		}

		/**
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 * @param string $file
		 */
		public function addFile($file){
			$this->file = $file;
			$this->crawlFile();
			return $this;
		}

		/**
	 	 * Constrcut crawler with file
	 	 *
		 * @version 0.6
		 * @since 0.6
		 *
		 * @access public 
		 */
		public function crawlFile(){
			if($this->getFile() !== null && !empty($this->getFile())):
				$this->crawler->addXmlContent(file_get_contents($this->getFile()));
			endif;

			return $this;
		}


	}
}
