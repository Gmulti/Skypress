<?php

namespace Skypress\Models\Specification;

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