<?php

namespace App\Entities;

use App\Events\Domain as Event;
use App\Support\Traits\Entity\HasToString;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use LaravelDoctrine\ACL\Contracts\BelongsToOrganisations as BelongsToOrganizationsContract;
use LaravelDoctrine\ACL\Contracts\HasPermissions as HasPermissionsContract;
use LaravelDoctrine\ACL\Contracts\HasRoles as HasRolesContract;
use LaravelDoctrine\ACL\Organisations\BelongsToOrganisation;
use LaravelDoctrine\ACL\Permissions\HasPermissions;
use LaravelDoctrine\ACL\Roles\HasRoles;
use LaravelDoctrine\ORM\Auth\Authenticatable;
use LaravelDoctrine\ORM\Notifications\Notifiable;
use Somnambulist\Doctrine\Contracts\Activatable as ActivatableContract;
use Somnambulist\Doctrine\Contracts\GloballyTrackable as GloballyTrackableContract;
use Somnambulist\Doctrine\Traits\Activatable;
use Somnambulist\Doctrine\Traits\GloballyTrackable;
use Somnambulist\DomainEvents\Contracts\RaisesDomainEvents as RaisesDomainEventsContract;
use Somnambulist\DomainEvents\Traits\RaisesDomainEvents;

/**
 * Class User
 *
 * @package    App\Entities
 * @subpackage App\Entities\User
 */
class User implements
    AuthenticatableContract,
    AuthorizableContract,
    ActivatableContract,
    BelongsToOrganizationsContract,
    CanResetPasswordContract,
    GloballyTrackableContract,
    HasRolesContract,
    HasPermissionsContract,
    RaisesDomainEventsContract
{

    use Authenticatable, Authorizable, CanResetPassword;
    use GloballyTrackable;
    use Activatable;
    use BelongsToOrganisation;
    use HasRoles;
    use HasPermissions;
    use HasToString;
    use Notifiable;
    use RaisesDomainEvents;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var Carbon
     */
    protected $lastLogin;

    /**
     * @var ArrayCollection|Address[]
     */
    protected $addresses;

    /**
     * @var ArrayCollection|Organization[]
     */
    protected $organizations;

    /**
     * @var ArrayCollection|Permission[]
     */
    protected $permissions;

    /**
     * @var ArrayCollection|Role[]
     */
    protected $roles;




    /**
     * Constructor.
     *
     * @param string $uuid
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct($uuid, $name, $email, $password)
    {
        $this->name          = $name;
        $this->email         = $email;
        $this->password      = $password;
        $this->addresses     = new ArrayCollection();
        $this->organizations = new ArrayCollection();
        $this->permissions   = new ArrayCollection();
        $this->roles         = new ArrayCollection();

        $this->raise(new Event\UserCreated(['uuid' => $uuid, 'name' => $name, 'email' => $email]));
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @param string $password
     */
    public function updateAuthenticationCredentials($email, $password)
    {
        $properties = [
            'uuid'  => $this->uuid,
            'name'  => $this->name,
        ];
        if ($email != $this->email) {
            $properties['email'] = ['new' => $email, 'previous' => $this->email];
        }

        $this->email    = $email;
        $this->password = $password;

        $this->raise(new Event\AuthenticationCredentialsChanged($properties));
    }

    /**
     * @return Carbon
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param Carbon $carbon
     */
    public function updateLastLogin(Carbon $carbon)
    {
        $this->lastLogin = $carbon;

        $this->raise(new Event\UserLoggedIn(['uuid' => $this->uuid, 'date' => $carbon]));
    }

    /**
     * Returns all the roles that this user can grant to others
     *
     * @return ArrayCollection
     */
    public function getGrantableRoles()
    {
        $return = new ArrayCollection();

        /** @var Role $role */
        foreach ($this->roles as $role) {
            foreach ($role->getGrantable() as $r) {
                if (!$return->contains($r)) {
                    $return->add($r);
                }
            }
        }

        return $return;
    }

    /**
     * Returns all the permissions that this user can grant to others
     *
     * @return ArrayCollection
     */
    public function getGrantablePermissions()
    {
        $return = new ArrayCollection();

        /** @var Role $role */
        foreach ($this->permissions as $permission) {
            if (!$return->contains($permission)) {
                $return->add($permission);
            }
        }

        return $return;
    }



    /**
     * @return Address[]|ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
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
     * @return boolean
     */
    public function hasAddress(Address $address)
    {
        return $this->addresses->contains($address);
    }

    /**
     * @param Address $address
     *
     * @return boolean
     */
    public function hasAddressByType(Address $address)
    {
        return $this->addresses->containsKey($address->getType());
    }

    /**
     * @param Address $address
     *
     * @return $this
     */
    public function removeAddress(Address $address)
    {
        $this->addresses->removeElement($address);
        $this->raise(new Event\AddressRemovedFromEntity(['uuid' => $this->uuid, 'address' => $address]));

        return $this;
    }



    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return boolean
     */
    public function isRoot()
    {
        return $this->hasRoleByName(Role::ROLE_ROOT);
    }

    /**
     * @param Role $role
     *
     * @return $this
     */
    public function addRole(Role $role)
    {
        if (!$this->hasRole($role)) {
            $this->roles->add($role);
            $this->raise(new Event\GrantedRoleToUser(['uuid' => $this->uuid, 'role' => $role]));
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
        return $this->roles->contains($role);
    }

    /**
     * @param Role $role
     *
     * @return $this
     */
    public function removeRole(Role $role)
    {
        $this->roles->removeElement($role);
        $this->raise(new Event\RevokedRoleFromUser(['uuid' => $this->uuid, 'role' => $role]));

        return $this;
    }



    /**
     * @return ArrayCollection
     */
    public function getPermissions()
    {
        return $this->permissions;
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
            $this->raise(new Event\GrantedPermissionToUser(['uuid' => $this->uuid, 'permission' => $permission]));
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
        $this->raise(new Event\RevokedPermissionFromUser(['uuid' => $this->uuid, 'permission' => $permission]));

        return $this;
    }



    /**
     * @return ArrayCollection
     */
    public function getOrganizations()
    {
        return $this->organizations;
    }

    /**
     * Laravel Doctrine uses the correct spelling
     *
     * @return ArrayCollection
     */
    public function getOrganisations()
    {
        return $this->getOrganizations();
    }

    /**
     * @param Organization $organization
     *
     * @return $this
     */
    public function addOrganization(Organization $organization)
    {
        if (!$this->hasOrganization($organization)) {
            $this->organizations->add($organization);
            $this->raise(new Event\GrantedOrganizationToUser([
                'uuid' => $this->uuid, 'organization' => $organization
            ]));
        }

        return $this;
    }

    /**
     * @param Organization $organization
     *
     * @return boolean
     */
    public function hasOrganization(Organization $organization)
    {
        return $this->organizations->contains($organization);
    }

    /**
     * @param Organization $organization
     *
     * @return $this
     */
    public function removeOrganization(Organization $organization)
    {
        $organization->removeUser($this);

        if ( $this->hasOrganization($organization) ) {
            $this->organizations->removeElement($organization);
            $this->raise(new Event\RevokedOrganizationFromUser([
                'uuid' => $this->uuid, 'organization' => $organization
            ]));
        }

        return $this;
    }
}
