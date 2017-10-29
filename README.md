# Skypress

[![Build Status][travis-image]][travis-url] 

Skypress is a PHP library for WordPress CMS wants to make a response to several issues that revolve around WordPress:

* The Object Oriented Programming
* Maintainability projects
* Versioning
* Code portability

## How use ?

Execute : `composer dump`


## Features

* Service Container
* Pattern Specification

## Example

```php

use Skypress\Kernel;
use Skypress\Container;
use Skypress\Services\Specification\Specification;

class MyTheme extends Kernel {    
    public function execute(){
        parent::execute();

        $specServices = $this->getService("Specification");
        $data = array(
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
        $spec = $specServices->constructSpecification($data);
        if($spec->isSatisfedBy("foo")){
            echo "Yes";
        }


        if($spec->isSatisfedBy("biere")){
            echo "Yes";
        }
        else{
            echo "No";
        }
    }
}

$theme  = new MyTheme();

$container = new Container(
    array(
        new Specification()
    )
);

$theme->setContainer($container)
      ->execute();
```



[twitter-account]: https://twitter.com/TDeneulin
[travis-image]: https://travis-ci.org/Gmulti/deli-builder.svg?branch=master
[travis-url]: https://travis-ci.org/Gmulti/Skypress.svg?branch=dev