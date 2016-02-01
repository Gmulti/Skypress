<?php

namespace Skypress\Factory\Specification;

use Skypress\Models\SpecificationFactoryInterface;
use Skypress\Models\Specification\ContainsSpecification;
use Skypress\Models\Specification\EqualsSpecification;
use Skypress\Models\Specification\NotX;
use Skypress\Models\Specification\OrX;
use Skypress\Models\Specification\AndX;

class SpecificationFactory implements SpecificationFactoryInterface
{
    
    public function __construct(){
        $this->conditionTest = apply_filters('_specification_factory_condition_test', array(
            "equals"       => __('Equals', 'skypress'),
            "contains"     => __('Contains', 'skypress'),
            "not_equals"   => __('Not equals', 'skypress'), 
            "not_contains" => __('Not contains', 'skypress')
        ));
    }


    public function constructSpecification($data){

        $arraySpec = array();

        foreach ($data as $keyOr => $valueOr) {
            foreach ($valueOr as $keyAnd => $valueAnd) {
                $arraySpec[$keyOr][] = $this->getSpecificationFromConditionTest($valueAnd['condition_test'], $valueAnd['value']);
            }
        }

        
        $specification = $this->constructOrSpecification($arraySpec);

        return $specification;
    }

    protected function constructOrSpecification($arraySpec){
        $specification = null;

        if(count($arraySpec) > 1){
            foreach ($arraySpec as $key => $value) {
                if (array_key_exists($key+1, $arraySpec)) {
                    $specification = ($specification === null) ? 
                                      new OrX($this->constructAndSpecification($value), $this->constructAndSpecification($arraySpec[$key+1])) : 
                                      new OrX($specification, $this->constructAndSpecification($arraySpec[$key+1]));
                }
                else{
                    $specification = new OrX($specification, $this->constructAndSpecification($value));
                }
            }
        }
        else{
            $arraySpec     = array_values($arraySpec);
            $specification = $this->constructAndSpecification($arraySpec[0]);
        }

        return $specification;
    }

    protected function constructAndSpecification($andSpecs){
        $andSpecification = null;

        if(!empty($andSpecs) && count($andSpecs) === 1){
            return $andSpecs[0];
        }
        else{
            foreach ($andSpecs as $key => $value) {
                if (array_key_exists($key+1, $andSpecs)) {
                    $andSpecification = ($andSpecification === null) ? 
                                        new AndX($value, $andSpecs[$key+1]) : 
                                        new AndX($andSpecification, $andSpecs[$key+1]);       
                }
            }
        }

        return $andSpecification;
    }

    public function getSpecificationFromConditionTest($conditionTest, $value){

        if(!array_key_exists($conditionTest, $this->conditionTest)){
            return false;
        }

        $stringChoice = new ContainsSpecification($conditionTest);
        $spec         = "";

        if($stringChoice->isSatisfedBy("not")){
            if($stringChoice->isSatisfedBy("equals")){
                $spec = new NotX(new EqualsSpecification($value));
            }
            else{
                $spec = new NotX(new ContainsSpecification($value));
            }
        }
        else{
            if($stringChoice->isSatisfedBy("equals")){
                $spec = new EqualsSpecification($value);
            }
            else{
                $spec = new ContainsSpecification($value);
            }

        }

        return apply_filters("_specification_factory_from_condition_test", $spec, $conditionTest, $value);
    }
}