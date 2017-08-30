<?php

namespace Skypress\WordPress\Actions;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\Models\ContainerServiceInterface;
use Skypress\Models\ContainerInterface;

abstract class AbstractHook implements ContainerServiceInterface
{
    public function setContainerServices(ContainerInterface $containerServices){}
    public function preHooks(){}

}