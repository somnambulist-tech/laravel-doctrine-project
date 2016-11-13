<?php

namespace App\Support\Traits\Entity;

use App\Entities\Address;

/**
 * Class HasAddress
 *
 * @package    App\Support\Traits\Entity
 * @subpackage App\Support\Traits\Entity\HasAddress
 */
trait HasAddress
{

    /**
     * @var Address
     */
    protected $address;

    /**
     * @return Address
     */
    public function getAddress()
    {
        if (!$this->address) {
            $this->address = new Address();
        }

        return $this->address;
    }

    /**
     * @param Address $address
     *
     * @return $this
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;

        return $this;
    }
}
