<?php

namespace Skypress\Services\Specification;

use Skypress\Models\SpecificationFactoryInterface;
use Skypress\Models\ServiceInterface;
use Skypress\Factory\Specification\SpecificationFactory;

class Specification implements ServiceInterface
{
    
    public function __construct(SpecificationFactoryInterface $factory = null){
        $this->conditionTest = apply_filters('_specification_condition_test', array(
            "equals"       => __('Equals', 'skypress'),
            "contains"     => __('Contains', 'skypress'),
            "not-equals"   => __('Not equals', 'skypress'), 
            "not-contains" => __('Not contains', 'skypress')
        ));

        $this->specificationFactory = $factory;
    }

    public function getSpecificationFactory(){
        if (is_null($this->specificationFactory)) {
            $this->specificationFactory = $this->createDefaultSpecificationFactory();
        }

        return $this->specificationFactory;
    }

    public function createDefaultSpecificationFactory(){
        return new SpecificationFactory();
    }

    public function setFactory(SpecificationFactoryInterface $factory){
        $this->specificationFactory = $factory;
    }

    public function constructSpecification($data){
        return $this->getSpecificationFactory()
                    ->constructSpecification($data);
    }
}