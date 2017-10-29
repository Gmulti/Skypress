<?php

namespace Skypress\Entity;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

class CustomPostType {
    
    /**
     * @access public
     * @return array
     */
    public function getArgs(){
        return array();
    }

    /**
     * @access public
     * @return string
     */
    public function getSlug(){
        return "";
    }
}