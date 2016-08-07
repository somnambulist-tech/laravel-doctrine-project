<?php

namespace App\Traits\Repository;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait FindByName
 *
 * @package    App\Traits\Repository
 * @subpackage App\Traits\Repository\FindByName
 */
trait FindByName
{

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     *
     * @return mixed
     */
    abstract public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return null|object
     */
    abstract public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param string $name
     *
     * @return ArrayCollection
     */
    public function findByName($name)
    {
        return $this->findBy(['name' => $name], ['name' => 'ASC']);
    }

    /**
     * @param string $name
     *
     * @return null|object
     */
    public function findOneByName($name)
    {
        return $this->findOneBy(['name' => $name]);
    }
}
