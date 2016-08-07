<?php

namespace App\Traits\Repository;

/**
 * Trait FindBySlug
 *
 * @package    App\Traits\Repository
 * @subpackage App\Traits\Repository\FindBySlug
 */
trait FindBySlug
{

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     *
     * @return null|object
     */
    abstract public function findOneBy(array $criteria, array $orderBy = null);

    /**
     * @param string $slug
     *
     * @return null|object
     */
    public function findBySlug($slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }
}
