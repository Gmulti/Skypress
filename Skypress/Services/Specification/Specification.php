<?php

namespace Skypress\Services\Specification;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\Models\SpecificationFactoryInterface;
use Skypress\Models\ServiceInterface;
use Skypress\Factory\Specification\SpecificationFactory;

class Specification implements ServiceInterface
{
    /**
     * @param SpecificationFactoryInterface|null $factory 
     */
    public function __construct(SpecificationFactoryInterface $factory = null){
        $this->conditionTest = apply_filters('_specification_condition_test', array(
            "equals"       => __('Equals', 'skypress'),
            "contains"     => __('Contains', 'skypress'),
            "not-equals"   => __('Not equals', 'skypress'), 
            "not-contains" => __('Not contains', 'skypress')
        ));

        $this->specificationFactory = $factory;
    }

    /**
     * @return SpecificationFactoryInterface
     */
    public function getSpecificationFactory(){
        if (is_null($this->specificationFactory)) {
            $this->specificationFactory = $this->createDefaultSpecificationFactory();
        }

        return $this->specificationFactory;
    }

    /**
     * @return SpecificationFactory
     */
    public function createDefaultSpecificationFactory(){
        return new SpecificationFactory();
    }


    /**
     *
     * @param SpecificationFactoryInterface $factory
     * @return Specification
     */
    public function setFactory(SpecificationFactoryInterface $factory){
        $this->specificationFactory = $factory;
        return $this;
    }

    /**
     *
     * @param array $data
     * @return Skypress\Models\SpecificationFactoryInterface
     */
    public function constructSpecification($data){
        return $this->getSpecificationFactory()
                    ->constructSpecification($data);
    }
}