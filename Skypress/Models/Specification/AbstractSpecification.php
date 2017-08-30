<?php
namespace Skypress\Models\Specification;

defined( 'ABSPATH' ) or die( 'Cheatin&#8217; uh?' );

use Skypress\Models\Specification\SpecificationInterface;
use Skypress\Models\Specification\AndX;
use Skypress\Models\Specification\OrX;
use Skypress\Models\Specification\NotX;

/**
 * @version 1.0.0
 * @since 1.0.0
 * 
 * @author Thomas DENEULIN <thomas@delipress.io> 
 */
abstract class AbstractSpecification implements SpecificationInterface
{
    /**
     *
     * @param $item
     *
     * @return bool
     */
    abstract public function isSatisfedBy($item);

    /**
     *
     * @param SpecificationInterface $spec
     *
     * @return SpecificationInterface
     */
    public function andX(SpecificationInterface $spec)
    {
        return new AndX($this, $spec);
    }

    /**
     *
     * @param SpecificationInterface $spec
     *
     * @return SpecificationInterface
     */
    public function orX(SpecificationInterface $spec)
    {
        return new OrX($this, $spec);
    }

    /**
     *
     * @return SpecificationInterface
     */
    public function notX()
    {
        return new NotX($this);
    }
}