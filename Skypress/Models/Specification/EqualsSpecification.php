<?php

namespace Skypress\Models\Specification;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\Models\Specification\AbstractSpecification;

class EqualsSpecification extends AbstractSpecification
{
     public function __construct($string){
          $this->string = $string;
     }

    public function isSatisfedBy($item){     
        return $this->string === $item;
    }
}