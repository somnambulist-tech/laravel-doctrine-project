<?php

namespace App\Repositories;

use App\Contracts\Repository\PermissionRepository as PermissionRepositoryContract;
use App\Support\AppEntityRepository;
use App\Traits\Repository\FindByName;

/**
 * Class PermissionRepository
 *
 * @package    App\Repositories
 * @subpackage App\Repositories\PermissionRepository
 */
class PermissionRepository extends AppEntityRepository implements PermissionRepositoryContract
{

    use FindByName;

}
