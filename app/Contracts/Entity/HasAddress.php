<?php

namespace App\Contracts\Entity;

use App\Entities\Address;

/**
 * Interface HasAddress
 *
 * @package    App\Contracts\Entity
 * @subpackage App\Contracts\Entity\HasAddress
 */
interface HasAddress
{

    /**
     * @return Address
     */
    public function getAddress();

    /**
     * @param Address $address
     *
     * @return $this
     */
    public function setAddress(Address $address);
}
