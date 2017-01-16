<?php

use LaravelDoctrine\ORM\IlluminateRegistry as DoctrineRegistry;
use Doctrine\ORM\EntityManager;

/**
 * Trait EnsureLaravelModuleDoctrineClosed
 */
trait EnsureLaravelModuleDoctrineClosed
{

    /**
     * Ensures that all Doctrine entity managers are closed and all connections closed
     */
    protected function ensureDoctrineClosed()
    {
        if (!method_exists($this, 'getModule')) {
            return;
        }

        try {
            /** @var \Codeception\Module\Laravel5 $l5 */
            $l5 = $this->getModule('Laravel5');

            /*
             * Destroy ALL doctrine object managers
             */
            $registry = $l5->app->make(DoctrineRegistry::class);

            $this->closeDoctrineRegistryConnections($registry);

        } catch (\Codeception\Exception\ModuleException $e) {
            // Laravel5 is not enabled, so meh!
        }
    }

    /**
     * @param DoctrineRegistry $registry
     */
    protected function closeDoctrineRegistryConnections(DoctrineRegistry $registry)
    {
        foreach ($registry->getManagers() as $name => $manager) {
            if ($manager instanceof EntityManager) {
                $manager->close();
                $manager->getConnection()->close();
            }

            $registry->resetManager($name);
        }
    }
}
