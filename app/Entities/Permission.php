<?php

namespace App\Entities;

use LaravelDoctrine\ACL\Contracts\Permission as PermissionContract;
use App\Support\Traits\Entity\HasToString;
use Somnambulist\Doctrine\Contracts\Trackable as TrackableContract;
use Somnambulist\Doctrine\Traits\Trackable;

/**
 * Class Permission
 *
 * @package    App\Entities
 * @subpackage App\Entities\Permission
 */
class Permission implements TrackableContract, PermissionContract
{

    use Trackable;
    use HasToString;

    /**
     * Constructor.
     *
     * @param null|string $name
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }
}
