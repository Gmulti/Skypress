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
class OrX extends AbstractSpecification
{

    /**
     * @var SpecificationInterface
     */
    protected $left;

    /**
     * @var SpecificationInterface
     */
    protected $right;

    /**
     *
     * @param SpecificationInterface $left
     * @param SpecificationInterface $right
     */
    public function __construct(SpecificationInterface $left, SpecificationInterface $right)
    {
        $this->left  = $left;
        $this->right = $right;
    }

    /**
     *
     * @param $item
     *
     * @return bool
     */
    public function isSatisfedBy($item)
    {
        return $this->left->isSatisfedBy($item) || $this->right->isSatisfedBy($item);
    }
}