<?php

namespace App\Repositories;

use App\Contracts\Repository\CountryRepository as CountryRepositoryContract;
use App\Support\AppEntityRepository;

/**
 * Class CountryRepository
 *
 * @package    App\Repositories
 * @subpackage App\Repositories\CountryRepository
 */
class CountryRepository extends AppEntityRepository implements CountryRepositoryContract
{

}
