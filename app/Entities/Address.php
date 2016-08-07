<?php

namespace App\Entities;

use App\Enumerations\AddressType;
use Somnambulist\Doctrine\Contracts\GloballyTrackable as GloballyTrackableContract;
use Somnambulist\Doctrine\Traits\GloballyTrackable;

/**
 * Class Address
 *
 * @package    App\Entities
 * @subpackage App\Entities\Address
 */
class Address implements GloballyTrackableContract
{

    use GloballyTrackable;

    /**
     * @var AddressType
     */
    protected $type;
    
    /**
     * @var string
     */
    protected $addressLine1;

    /**
     * @var string
     */
    protected $addressLine2;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $ward;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $postcode;

    /**
     * @var Country
     */
    protected $country;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;



    /**
     * Constructor.
     *
     * @param null|string  $line1
     * @param null|string  $line2
     * @param null|string  $city
     * @param null|string  $state
     * @param null|string  $postcode
     * @param null|Country $country
     */
    public function __construct(
        $line1 = null,
        $line2 = null,
        $city = null,
        $state = null,
        $postcode = null,
        $country = null
    ) {
        $this->addressLine1 = $line1;
        $this->addressLine2 = $line2;
        $this->city         = $city;
        $this->state        = $state;
        $this->postcode     = $postcode;
        $this->setCountry($country);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param string $separator
     *
     * @return string
     */
    public function toString($separator = "\n")
    {
        $pieces = [];

        if ($this->getAddressLine1()) {
            $pieces[] = $this->getAddressLine1();
        }
        if ($this->getAddressLine2()) {
            $pieces[] = $this->getAddressLine2();
        }
        if ($this->getCity()) {
            $pieces[] = $this->getCity();
        }
        if ($this->getState()) {
            $pieces[] = $this->getState();
        }
        if ($this->getPostcode()) {
            $pieces[] = $this->getPostcode();
        }
        if ($this->getCountry()) {
            $pieces[] = $this->getCountry()->getName();
        }

        return implode($separator, $pieces);
    }

    /**
     * @return AddressType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param AddressType $type
     *
     * @return $this
     */
    public function setType(AddressType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * @param string $addressLine1
     *
     * @return Address
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * @param string $addressLine2
     *
     * @return Address
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getWard()
    {
        return $this->ward;
    }

    /**
     * @param string $ward
     *
     * @return $this
     */
    public function setWard($ward)
    {
        $this->ward = $ward;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     *
     * @return Address
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     *
     * @return Address
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Returns true if this address can be evaluated as the same $address
     *
     * @param Address $address
     *
     * @return boolean
     */
    public function isSameAs(Address $address)
    {
        return
            $this->getAddressLine1() == $address->getAddressLine1() &&
            $this->getAddressLine2() == $address->getAddressLine2() &&
            $this->getCity() == $address->getCity() &&
            $this->getState() == $address->getState() &&
            $this->getPostcode() == $address->getPostcode() &&
            $this->getCountry() === $address->getCountry()
        ;
    }
}
