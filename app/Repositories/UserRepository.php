<?php

namespace App\Repositories;

use App\Support\Contracts\Repository\UserRepository as UserRepositoryContract;
use App\Entities\User;
use App\Support\AppEntityRepository;
use App\Support\Traits\Repository\FindByName;
use App\Support\Traits\Repository\FindByUUID;

/**
 * Class UserRepository
 *
 * @package    App\Repositories
 * @subpackage App\Repositories\UserRepository
 */
class UserRepository extends AppEntityRepository implements UserRepositoryContract
{

    use FindByName;
    use FindByUUID;

    /**
     * @param string $email
     *
     * @return null|User
     */
    public function findOneByEmailAddress($email)
    {
        return $this->findOneBy(['email' => $email]);
    }
}
