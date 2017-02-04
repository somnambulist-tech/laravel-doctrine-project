<?php

namespace App\Providers;

use Doctrine\ORM\EntityManager;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelDoctrine\ORM\IlluminateRegistry;

/**
 * Class EventServiceProvider
 *
 * @package    App\Providers
 * @subpackage App\Providers\EventServiceProvider
 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * Doctrine Domain Event Subscribers
     *
     * @var array
     */
    protected $doctrineSubscribers = [

    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->registerDoctrineDomainEventSubscribers();
    }

    /**
     * Register all the domain event subscribers
     */
    private function registerDoctrineDomainEventSubscribers()
    {
        /** @var EntityManager $em */
        $registry = $this->app->make(IlluminateRegistry::class);

        foreach ($this->doctrineSubscribers as $em => $subscribers) {
            $em = $registry->getManager($em);

            foreach ($subscribers as $subscriber) {
                $em->getEventManager()->addEventSubscriber($this->app->make($subscriber));
            }
        }
    }
}
