<?php
/**
 * Plugin Name: Skypress
 * Plugin URI: http://skypress.fr
 * Description: Framework Skypress pour WordPress
 * Version: 0.6
 * Author: GTD-IT
 */

require_once(__DIR__ . '/Skypress/vendor/autoload.php');

use Symfony\Component\ClassLoader\UniversalClassLoader;

/**
 * Skypress
 *
 * @author Thomas DENEULIN <contact@skypress.fr>
 * @since 0.6
 * @version 0.6
 */
class Skypress{

	public function hooks(){
		add_action( 'muplugins_loaded' , array($this,'pluginLoaded'),10);
	}

	public function pluginLoaded(){
		$loader = new UniversalClassLoader();

		$theme = wp_get_theme();
		$name  = $theme->template;
		$dir   = $theme->theme_root . '/' . $name;


		define('NAME_THEME_SP',$name);
		define('DIR_THEME_SP', $dir);

		$registerNamespaces = array(
			'Skypress' => __DIR__ ,
		    ucfirst($name) => $dir . '/src',
		);

		$plugins = $this->getPlugins();

		if (null !== $plugins):
			foreach ($plugins as $key => $plugin):
				$registerNamespaces[$key] = $plugin;
			endforeach;
		endif;


		$registers = apply_filters( 'register_namespace', $registerNamespaces);

		$loader->registerNamespaces($registers);

		$loader->register();
	}

	public function getPlugins(){

		$plugin_root = WP_PLUGIN_DIR;
		$wp_plugins = array();

		try {
			if ( !empty($plugin_folder) )
				$plugin_root .= $plugin_folder;

			// Files in wp-content/plugins directory
			$plugins_dir = opendir( $plugin_root);
			$plugin_files = array();
			if ( $plugins_dir ) {
				while (($file = readdir( $plugins_dir ) ) !== false ) {
					if ( substr($file, 0, 1) == '.' )
						continue;
					if ( is_dir( $plugin_root.'/'.$file ) ) {
						$plugins_subdir = opendir( $plugin_root.'/'.$file );
						if ( $plugins_subdir ) {
							while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
								if ( substr($subfile, 0, 1) == '.' )
									continue;
								if ( substr($subfile, -4) == '.php' )
									$plugin_files[] = "$file/$subfile";
							}
							closedir( $plugins_subdir );
						}
					} else {
						if ( substr($file, -4) == '.php' )
							$plugin_files[] = $file;
					}
				}
				closedir( $plugins_dir );
			}

			if ( empty($plugin_files) )
				return $wp_plugins;

			foreach ( $plugin_files as $plugin_file ) {

				if ( !is_readable( "$plugin_root/$plugin_file" ) )
					continue;

				$plugin_dir = $plugin_root;
				$plugin_name = dirname($plugin_file);

				if(!array_key_exists($plugin_name, $wp_plugins)):
					$wp_plugins[ $plugin_name ] = $plugin_dir;
				endif;
			}
		} catch (Exception $e) {
			return null;
		}

		return $wp_plugins;
	}
}

$skypress = new Skypress();
$skypress->hooks();










