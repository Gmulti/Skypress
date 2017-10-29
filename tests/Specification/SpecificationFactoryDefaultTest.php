<?php


use Skypress\Services\Specification\Specification;
use Skypress\Factory\Specification\SpecificationFactory;

final class SpecificationFactoryDefaultTest extends WP_UnitTestCase
{
    public function setUp(){
        $this->specification = new Specification();
        $this->data          = array(
            array(
                array(
                    "condition_test" => "equals",
                    "value"          => "foo"

                ),
                array(
                    "condition_test" => "contains",
                    "value"          => "foo"
                )
            ),
            array(
                array(
                    "condition_test" => "contains",
                    "value"          => "bar"

                ),
            )
        );
    }


    public function testSpecificationFactoryDefault(){
        $desiredResult = "SpecificationFactory";

        $result = $this->specification->getSpecificationFactory();

        $this->assertInstanceOf(
            SpecificationFactory::class,
            $result
        );
    }

    public function testConstructSpecificationIsSatisfed(){
        $spec = $this->specification->constructSpecification($this->data);
        

        $this->assertTrue($spec->isSatisfedBy("foo"));
    }

    public function testConstructSpecificationIsNotSatisfed(){
        $spec = $this->specification->constructSpecification($this->data);
        

        $this->assertFalse($spec->isSatisfedBy("beer"));
    }

}
