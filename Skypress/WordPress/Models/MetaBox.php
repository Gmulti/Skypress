<?php

namespace Skypress\WordPress\Models;

use Skypress\Models\HooksInterface;

/**
 * Metabox
 *
 * @author Thomas DENEULIN <thomas@delipress.io>
 * @version 1.0.0
 * @since 1.0.0
 */
abstract class Metabox implements HooksInterface{

    /**
     * @access protected
     */
    protected $metaBoxes;

    /**
     * @see Skypress\Models\HooksInterface
     */
    public function hooks(){

        add_action( 'add_meta_boxes', array( $this, 'addMetaBox' ), 1, 0 );
    }

    /**
     * @return void
     */
    public function addMetaBox(){

        foreach ($this->metaBoxes as $key => $metaBox) {
            foreach ($metaBox["post_types"] as $keyPostType => $postType) {
                add_meta_box(
                    $key,
                    $metaBox["title"],
                    array( $this, $metaBox["callback"] ),
                    $postType
                );
            }
        }
    }

}









