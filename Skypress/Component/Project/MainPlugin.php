<?php

namespace Skypress\Component\Project;


use Skypress\Component\Models\HooksInterface;

if(!class_exists('MainPlugin')){

	/**
	 * Main plugin
	 *
	 * @version 0.5
	 * @since 0.5
	 *
	 * @author Thomas DENEULIN <contact@skypress.fr>
	 *
	 */
    class MainPlugin extends MainProject
    {

	    /**
	     *
	     * @version 1.0
	     * @since 1.0
	     * @access protected
	     * @var array
	     *
	     */
	    protected $classes = array();


	    public function execute(){

	        parent::execute();

	        foreach ($this->getClasses() as $key => $class):
	            if ($class instanceOf HooksInterface):
	                $class->hooks();
	            endif;
	        endforeach;

	    }


	    public function getClasses(){
	        return $this->classes;
	    }

	    public function getClass($key){
	        if(array_key_exists($key, $this->classes)):
	            return  $this->classes[$key];
	        endif;

	        return null;
	    }

	    public function setClass($class, $key = null){
	        $key = ($key !== null) ? $key : apply_filters( 'key_class_' . KernelSkypress::getTypeFilter() . '_' . get_class($class) , get_class($class) ) ;

	        if($this->getClass($key) === null):
	            $this->classes[$key] = $class;
	        else:
	            throw new \Exception("This class " . get_class($class) . " already exist");
	        endif;
	    }

    }

}
