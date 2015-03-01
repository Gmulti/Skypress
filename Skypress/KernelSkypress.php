<?php

namespace Skypress;

use Skypress\Component\Project\MainTheme;
use Skypress\Component\Project\MainPlugin;

use Skypress\Component\Mediator\ServiceContainerMediator;
use Skypress\Component\Service\MediatorService;

if(!class_exists('KernelSkypress')){


    /**
     * KernelSkypress framework Skypress
     *
     * 
     *     // Example
     *     $theme = KernelSkypress::getInstance('theme');
     *     $theme->execute();
     *
     * @author Thomas DENEULIN <contact@skypress.fr>
     * @since 0.5
     * @version 0.5
     */
    abstract class KernelSkypress
    {
        protected static $theme = null;

        protected static $plugins = array();

        protected static $typeFilter = null;

        public static $configs = array();

        /**
         * Get instance singleton main
         *
         * @static
         * @access public
         *
         * @param  string $type   (theme|plugin)
         * @param  array  $config
         *
         * @return skeleton
         */
        public static function getInstance($type, $config = array(), $namePlugin = null)
        {
            $skeleton = false;


            if(in_array($type, array('theme','plugin'))):

                if(empty($config)):
                    $config = self::getConfig($type, $namePlugin);
                else:
                    if(!is_array($config) ):
                        throw new \Exception("Your configuration must be an array");
                    endif;
                endif;

                if($type == 'theme'):

                    self::$typeFilter = 'theme';

                    if (self::$theme == null) :
                        $skeleton = self::$theme = new MainTheme($config);
                    else:
                        $skeleton = self::$theme;
                    endif;

                  

                elseif($type == 'plugin'):

                    if($namePlugin == null):
                        throw new \Exception("We need the name of your plugin");
                    else:

                        self::$typeFilter = $namePlugin;

                        if(array_key_exists($namePlugin, self::$plugins)):
                            $skeleton = self::$plugins[$namePlugin];
                        else:
                            $skeleton = self::$plugins[$namePlugin] = new MainPlugin($config);
                        endif;
                    endif;

                endif;
            else:
                throw new \Exception("You try to instantiate an unknown skeleton");

            endif;

            return $skeleton;
        }

        /**
         * Return array config with a key or/and subkey
         *
         * @since 0.5
         * @version 0.5
         * @access public
         * @static
         *
         * @param  string $type   Type de config
         * @param  string $subkey sub key config
         * @param  string $subkey sub key config
         * @param  string $namePlugin Nom du plugin
         * @return array
         */
        public static function getConfigByKey($type, $key, $subkey = '', $namePlugin = null){

            $returnConfig = array();
            $config = KernelSkypress::getConfig($type, $namePlugin);
            $return = true;

            if(array_key_exists($key, $config)):
                if(!empty($subkey)):
                    if(array_key_exists($key, $config)):
                        $returnConfig = $config[$key][$subkey];
                    else:
                        $return = false;
                    endif;
                else:
                    $returnConfig = $config[$key];
                endif;
            else:
                $return = false;
            endif;

            if(!$return):
                 throw new \Exception("You try to access a key that does not exist");
            endif;

            return $returnConfig;
        }

        /**
         * Get config instance skeleton
         *
         * @since 0.5
         * @version 0.5
         * @static
         * @access public
         *
         * @param  string $type (theme|plugin)
         * @return array
         */
        public static function getConfig($type, $namePlugin = null){
            $themeConfig = array(
                'services' => array(
                    'menu' => array(
                        'active' => 0,
                        'construct' => array(),
                    ),
                    'custom-post-type' => array(
                        'active' => 0,
                        'construct' => array(
                            array(
                                'slug' => '',
                                'args'  => array(),
                                'labels'=> array(),
                            ),

                        ),
                    ),
                    'taxonomy' => array(
                        'active' => 0,
                        'construct' => array(
                            array(
                                'slug'      => '',
                                'post_type' => array(),
                                'args'      => array(),
                                'labels'    => array(),
                            ),
                        ),
                    ),
                    'term' => array(
                        'active' => 0,
                        'construct' => array(
                            array(
                                'slug' => '',
                                'taxonomies' => array(),
                            ),
                        ),
                    ),
                )
            );

            KernelSkypress::$configs = $themeConfig;

            $config = array();

            if ($type == 'theme'):
                $config = apply_filters('skeleton_config_default_theme', KernelSkypress::$configs);
            else:
                if($namePlugin != null):
                    $config = apply_filters('skeleton_config_default_plugin_' . $namePlugin, KernelSkypress::$configs);
                endif; 
            endif;
           
            return $config;
        }

        /**
         * Return name theme
         *
         * @since 0.5
         * @version 0.5
         * @static
         * @access public
         * 
         * @return string
         */
        public static function getTheme(){
            return self::$theme;
        }

        /**
         * Return list plugins
         *
         * @since 0.5
         * @version 0.5
         * @static
         * @access public
         * 
         * @return array
         */
        public static function getPlugins(){
            return self::$plugins;
        }

        /**
         * Return type filter
         *
         * @since 0.5
         * @version 0.5
         * @static
         * @access public
         * 
         * @return array
         */
        public static function getTypeFilter(){
            return self::$typeFilter;
        }

    }

}
