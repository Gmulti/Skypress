<?php

namespace Skypress;

use Skypress\ContainerServiceTrait;
use Skypress\Models\ServiceInterface;

abstract class Kernel{
    use ContainerServiceTrait;

    public function execute(){

        foreach ($this->getServices() as $key => $service) {
            switch(true) {  
                case $service instanceof HooksAdminInterface:
                    if (is_admin()) {
                        $service->hooks();
                    }
                    break;

                case $service instanceof HooksFrontInterface:
                    if (!is_admin()) {
                        $service->hooks();
                    }
                    break;

                case $service instanceof HooksInterface:
                    $service->hooks();
                    break;
            }
        }

        return $this;

    }

}

