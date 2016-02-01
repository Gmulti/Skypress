<?php
namespace Skypress\Models\Specification;

use Skypress\Models\Specification\AbstractSpecification;

/**
 * @version 1.0.0
 * @since 1.0.0
 * 
 * @author Thomas DENEULIN <contact@wp-god.com> 
 */
class NotX extends AbstractSpecification
{

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