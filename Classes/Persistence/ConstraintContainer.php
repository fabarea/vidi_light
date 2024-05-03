<?php

namespace Fab\VidiLight\Persistence;

use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;

/**
 * Class ConstraintContainer
 */
class ConstraintContainer
{
    /**
     * @var ConstraintInterface
     */
    protected $constraint;

    /**
     * @return ConstraintInterface
     */
    public function getConstraint()
    {
        return $this->constraint;
    }

    /**
     * @param ConstraintInterface $constraint
     * @return $this
     */
    public function setConstraint($constraint)
    {
        $this->constraint = $constraint;
        return $this;
    }
}
