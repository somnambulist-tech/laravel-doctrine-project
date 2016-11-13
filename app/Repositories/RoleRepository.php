<?php

namespace App\Repositories;

use App\Support\Contracts\Repository\RoleRepository as RoleRepositoryContract;
use App\Support\AppEntityRepository;
use App\Support\Traits\Repository\FindByName;

/**
 * Class RoleRepository
 *
 * @package    App\Repositories
 * @subpackage App\Repositories\RoleRepository
 */
class RoleRepository extends AppEntityRepository implements RoleRepositoryContract
{

    use FindByName;

}
