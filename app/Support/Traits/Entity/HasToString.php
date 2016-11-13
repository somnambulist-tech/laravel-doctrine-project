<?php

namespace App\Support\Traits\Entity;

use Somnambulist\Doctrine\Contracts\Nameable as NameableContract;

/**
 * Trait HasToString
 *
 * @package    App\Support\Traits\Entity
 * @subpackage App\Support\Traits\Entity\HasToString
 */
trait HasToString
{

    /**
     * @return string
     */
    public function __toString()
    {
        if (method_exists($this, 'getDisplayName')) {
            return $this->getDisplayName();
        }
        if ($this instanceof NameableContract) {
            return $this->getName();
        }
        if (property_exists($this, 'name')) {
            return $this->name;
        }

        throw new \RuntimeException(__CLASS__ . ' does not implement Nameable, Displayable or have a name property');
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }
}
