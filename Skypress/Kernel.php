<?php

namespace Skypress;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\ContainerServiceTrait;
use Skypress\Models\ServiceInterface;
use Skypress\Models\HooksAdminInterface;
use Skypress\Models\HooksFrontInterface;
use Skypress\Models\HooksInterface;
use Skypress\Models\ActivationInterface;
use Skypress\Models\DeactivationInterface;

abstract class Kernel{
    
    use ContainerServiceTrait;

    /** 
     * @var string
     */
    protected $slug;
    
    /**
     *
     * @param stdClass $action
     */
    protected function preHooks($action){
        if($action instanceOf AbstractHook){
            $action->preHooks();    
        }
    }

    /**
     * @return Kernel
     */
    public function execute(){

        foreach ($this->getActions() as $key => $action) {
            
            switch(true) {  
                case $action instanceOf HooksAdminInterface:
                    if (is_admin()) {
                        $this->preHooks($action);
                        $action->hooks();
                    }
                    break;

                case $action instanceOf HooksFrontInterface:
                    if (!is_admin()) {
                        $this->preHooks($action);
                        $action->hooks();
                    }
                    break;

                case $action instanceOf HooksInterface:
                    $this->preHooks($action);
                    $action->hooks();
                    break;
            }
        }

        return $this;

    }
    
    /**
     * @return void
     */
    public function executePlugin(){
        switch (current_filter()) {
            case 'plugins_loaded':
                foreach ($this->getActions() as $key => $action) {
                    switch(true) {  
                        case $action instanceOf HooksAdminInterface:
                            if (is_admin()) {
                                $this->preHooks($action);
                                $action->hooks();
                            }
                            break;

                        case $action instanceOf HooksFrontInterface:
                            if (!is_admin()) {
                                $this->preHooks($action);
                                $action->hooks();
                            }
                            break;

                        case $action instanceOf HooksInterface:
                            $this->preHooks($action);
                            $action->hooks();
                            break;
                    }
                }
                break;
            case 'activate_' . $this->slug . '/' . $this->slug . '.php':
                foreach ($this->getActions() as $key => $action) {
                    
                    if($action instanceOf ActivationInterface){
                        $this->preHooks($action);
                        $action->activation();
                    }
                }
                break;
            case 'deactivate_' . $this->slug . '/' . $this->slug . '.php':
                foreach ($this->getActions() as $key => $action) {

                    if($action instanceOf DeactivationInterface){
                        $this->preHooks($action);
                        $action->deactivation();
                    }
                }
                break;
        }
    }

}

