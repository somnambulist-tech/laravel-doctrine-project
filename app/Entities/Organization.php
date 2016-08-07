<?php

namespace App\Entities;

use App\Enumerations\AddressType;
use App\Events\Domain as Event;
use App\Traits\Entity\HasToString;
use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ACL\Contracts\Organisation as OrganizationContract;
use Somnambulist\Doctrine\Contracts\GloballyTrackable as GloballyTrackableContract;
use Somnambulist\Doctrine\Traits\GloballyTrackable;
use Somnambulist\DomainEvents\Contracts\RaisesDomainEvents as RaisesDomainEventsContract;
use Somnambulist\DomainEvents\Traits\RaisesDomainEvents;

/**
 * Class Organization
 *
 * @package    App\Entities
 * @subpackage App\Entities\Organization
 */
class Organization implements OrganizationContract, GloballyTrackableContract, RaisesDomainEventsContract
{

    use GloballyTrackable;
    use HasToString;
    use RaisesDomainEvents;

    /**
     * @var Organization
     */
    protected $parent;

    /**
     * @var ArrayCollection|Organization[]
     */
    protected $children;

    /**
     * @var ArrayCollection|Address[]
     */
    protected $addresses;

    /**
     * @var ArrayCollection|User[]
     */
    protected $users;



    /**
     * Constructor.
     *
     * @param string $uuid
     * @param string $name
     */
    public function __construct($uuid, $name)
    {
        $this->uuid      = $uuid;
        $this->name      = $name;
        $this->addresses = new ArrayCollection();
        $this->children  = new ArrayCollection();
        $this->users     = new ArrayCollection();

        $this->raise(new Event\OrganizationCreated(['uuid' => $this->uuid, 'name' => $name]));
    }

    /**
     * @return Organization
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Organization $parent
     *
     * @return $this
     */
    public function setParent(Organization $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Organization[]|ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Organization $organization
     *
     * @return $this
     */
    public function addChild(Organization $organization)
    {
        if (!$this->hasChild($organization)) {
            $this->children->add($organization);
        }

        return $this;
    }

    /**
     * @param Organization $organization
     *
     * @return boolean
     */
    public function hasChild(Organization $organization)
    {
        return $this->children->contains($organization);
    }

    /**
     * @param Organization $organization
     *
     * @return $this
     */
    public function removeChild(Organization $organization)
    {
        $this->children->removeElement($organization);
        if ($organization->getParent() === $this) {
            $organization->setParent(null);
        }

        return $this;
    }



    /**
     * @return ArrayCollection|Address[]
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param string|AddressType $type
     *
     * @return null|Address
     */
    public function getAddressByType($type)
    {
        $entity = $this->addresses->filter(
            function ($entity) use ($type) {
                return ((string)$entity->getType() == (string)$type);
            }
        )->first();

        return $entity ?: null;
    }

    /**
     * @param Address $address
     *
     * @return $this
     */
    public function addAddress(Address $address)
    {
        if (!$this->hasAddress($address)) {
            $this->addresses->set($address->getType(), $address);
            $this->raise(new Event\AddressAddedToEntity(['uuid' => $this->uuid, 'address' => $address]));
        }

        return $this;
    }

    /**
     * @param Address $address
     *
     * @return bool
     */
    public function hasAddress(Address $address)
    {
        return $this->addresses->contains($address->getType());
    }

    /**
     * @param Address $address
     *
     * @return $this
     */
    public function removeAddress(Address $address)
    {
        $this->addresses->remove($address->getType());
        $this->raise(new Event\AddressRemovedFromEntity(['uuid' => $this->uuid, 'address' => $address]));

        return $this;
    }



    /**
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function addUser(User $user)
    {
        if (!$this->hasUser($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    /**
     * @param User $user
     *
     * @return boolean
     */
    public function hasUser(User $user)
    {
        return $this->users->contains($user);
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function removeUser(User $user)
    {
        $user->removeOrganization($this);
        if ($this->hasUser($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }
}
