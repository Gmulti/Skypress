<?php

namespace Skypress\Models\Specification;

use Skypress\Models\Specification\AbstractSpecification;

class ContainsSpecification extends AbstractSpecification
{
    public function __construct($string){
        $this->string = $string;
    }

    public function isSatisfedBy($item){    
        $pos = strpos($this->string, $item);

        if ($pos === false) {
            return false;
        } else {
            return true;
        }
    }
}