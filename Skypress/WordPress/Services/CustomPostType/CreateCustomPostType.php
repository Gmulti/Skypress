<?php

namespace Skypress\WordPress\Services\CustomPostType;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\Entity\CustomPostType;

class CreateCustomPostType  {

    /**
     * Register a custom post type on init action
     *
     * @param  CustomPostType $obj
     * @access public
     *
     * @return void
     */
    public function registerPostType(CustomPostType $obj){

        if( post_type_exists( $obj->getSlug() ) ) {
            return;
        }
        $args = $obj->getArgs();
        $slug = $obj->getSlug();

        // if(in_array('thumbnail', $args['supports'])){
        //     add_action('after_setup_theme',function() use($slug, $args){
                
        //     });
        // }

        add_action('init', function() use( $slug, $args ) {
            register_post_type( $slug, $args );
        });
    }
}