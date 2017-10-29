<?php
namespace Skypress\Models\Specification;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\Models\Specification\AbstractSpecification;

/**
 * @version 1.0.0
 * @since 1.0.0
 * 
 * @author Thomas DENEULIN <thomas@delipress.io> 
 */
class NotX extends AbstractSpecification
{
    /**
     * @var SpecificationInterface
     */
    protected $specification;

    /**
     *
     * @param SpecificationInterface $specification
     */
    public function __construct(SpecificationInterface $specification)
    {
        $this->specification = $specification;
    }

    /**
     *
     * @param $item
     *
     * @return bool
     */
    public function isSatisfedBy($item)
    {
        return !$this->specification->isSatisfedBy($item);
    }
}