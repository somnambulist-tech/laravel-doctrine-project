<?php

namespace App\Traits\Repository;

/**
 * Trait FindByUUID
 *
 * @package    App\Traits\Repository
 * @subpackage App\Traits\Repository\FindByUUID
 */
trait FindByUUID
{

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return null|object
     */
    abstract public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param string $uuid
     *
     * @return null|object
     */
    public function findByUUID($uuid)
    {
        return $this->findOneBy(['uuid' => $uuid]);
    }
}
