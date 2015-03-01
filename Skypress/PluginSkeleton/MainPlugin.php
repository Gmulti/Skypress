<?php

namespace Skypress\PluginSkeleton;


use Skypress\KernelSkypress;
use Skypress\Component\Models\HooksInterface;

class MainPlugin implements HooksInterface
{
	
	/**
     *
     * @version 1.0
     * @since 1.0
     * @access protected
     * @var Skypress\Component\Project\MainPlugin
     *
     */
	protected $plugin;

	/**
     *
     * @version 1.0
     * @since 1.0
     * @access protected
     * @var string
     *
     */
	protected $namePlugin;

	public function __construct($namePlugin = null){

		$this->namePlugin = ($namePlugin === null) ? uniqid() : $namePlugin;
	}

  
    public function execute(){ 
        // Activation
		register_activation_hook( __FILE__, array( $this, 'pluginActivation' ) );

		// Uninstall
		register_uninstall_hook( __FILE__,  array( __CLASS__ , 'pluginUninstall' )  );

		// Loader
		add_action( 'plugins_loaded' , array( $this , 'pluginLoaded' ) );

    }

    public function pluginActivation(){

        if(!class_exists('Skypress')):
            $msg = __('You must have <a href="http://skypress.fr">Skypress framework</a> to use this plugin', 'ExportSP');
            wp_die($msg);
        endif;
    }

    public static function pluginUninstall(){

    }

    public function pluginLoaded(){
        $this->plugin = KernelSkypress::getInstance('plugin', array(), $this->namePlugin);
   		
    }

    public function hooks(){
        $this->plugin->execute();
    }
   
}