<?php

/**
 * Class DoctrineSetup
 *
 * @package DoctrineSetup
 * @author  Dave Redfern
 */
class DoctrineSetup
{

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public static function createEntityManager()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__ . '/../../bootstrap/app.php';

        $app
            ->loadEnvironmentFrom('.env.testing')
            ->make(Illuminate\Contracts\Console\Kernel::class)
            ->bootstrap()
        ;

        return $app->make('em');
    }
}
