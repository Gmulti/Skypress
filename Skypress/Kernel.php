<?php

namespace Skypress;

use Skypress\ContainerServiceTrait;
use Skypress\Models\ServiceInterface;
use Skypress\Models\HooksAdminInterface;
use Skypress\Models\HooksFrontInterface;
use Skypress\Models\HooksInterface;
use Skypress\Models\ActivationInterface;
use Skypress\Models\DeactivationInterface;

abstract class Kernel{
    use ContainerServiceTrait;

    protected $slug;

    public function execute(){

        foreach ($this->getActions() as $key => $action) {
            switch(true) {  
                case $action instanceof HooksAdminInterface:
                    if (is_admin()) {
                        $action->hooks();
                    }
                    break;

                case $action instanceof HooksFrontInterface:
                    if (!is_admin()) {
                        $action->hooks();
                    }
                    break;

                case $action instanceof HooksInterface:
                    $action->hooks();
                    break;
            }
        }

        return $this;

    }

    public function executePlugin(){

        switch (current_filter()) {
            case 'plugins_loaded':
                foreach ($this->getActions() as $key => $action) {
                    if($action instanceOf HooksAdminInterface && is_admin()){
                        $action->hooks();
                    }
                    else if($action instanceOf HooksInterface){
                        $action->hooks();
                    }
                }
                break;
                
            case 'activate_' . $this->slug . '/' . $this->slug . '.php"':
                foreach ($this->getActions() as $key => $action) {
                    if($action instanceOf ActivationInterface){
                        $action->hooks();
                    }
                }
                break;
            case 'deactivate_' . $this->slug . '/' . $this->slug . '.php':
                foreach ($this->getActions() as $key => $action) {
                    if($action instanceOf DeactivationInterface){
                        $action->hooks();
                    }
                }
                break;
        }
    }

}

