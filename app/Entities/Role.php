<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\ACL\Contracts\Role as RoleContract;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use App\Traits\Entity\HasToString;
use Somnambulist\Doctrine\Contracts\Trackable as TrackableContract;
use Somnambulist\Doctrine\Traits\Trackable;

/**
 * Class Role
 *
 * @package    App\Entities
 * @subpackage App\Entities\Role
 */
class Role implements TrackableContract, RoleContract
{

    use Trackable;
    use HasPermissions;
    use HasToString;

    const ROLE_ROOT  = 'root';
    const ROLE_USER  = 'user';
    const ROLE_ADMIN = 'admin';

    /**
     * @var ArrayCollection
     */
    protected $permissions;

    /**
     * @var ArrayCollection
     */
    protected $grantable;



    /**
     * Constructor.
     *
     * @param null|string  $name
     * @param Permission[] $permissions
     */
    public function __construct($name = null, array $permissions = [])
    {
        $this->name        = $name;
        $this->permissions = new ArrayCollection($permissions);
        $this->grantable   = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @return ArrayCollection
     */
    public function getGrantable()
    {
        return $this->grantable;
    }



    /**
     * @param Permission $permission
     *
     * @return $this
     */
    public function addPermission(Permission $permission)
    {
        if (!$this->hasPermission($permission)) {
            $this->permissions->add($permission);
        }

        return $this;
    }

    /**
     * @param Permission $permission
     *
     * @return boolean
     */
    public function hasPermission(Permission $permission)
    {
        return $this->permissions->contains($permission);
    }

    /**
     * @param Permission $permission
     *
     * @return $this
     */
    public function removePermission(Permission $permission)
    {
        $this->permissions->removeElement($permission);

        return $this;
    }



    /**
     * @param Role $role
     *
     * @return $this
     */
    public function addRole(Role $role)
    {
        if (!$this->hasRole($role)) {
            $this->grantable->add($role);
        }

        return $this;
    }

    /**
     * @param Role $role
     *
     * @return boolean
     */
    public function hasRole(Role $role)
    {
        return $this->grantable->contains($role);
    }

    /**
     * @param Role $role
     *
     * @return $this
     */
    public function removeRole(Role $role)
    {
        $this->grantable->removeElement($role);

        return $this;
    }
}
