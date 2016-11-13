<?php

namespace App\Support\Contracts\Entity;

use App\Entities\Address;

/**
 * Interface HasAddress
 *
 * @package    App\Support\Contracts\Entity
 * @subpackage App\Support\Contracts\Entity\HasAddress
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
