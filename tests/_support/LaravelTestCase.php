<?php

use LaravelDoctrine\ORM\IlluminateRegistry as DoctrineRegistry;
use Illuminate\Foundation\Testing\TestCase;

/**
 * Class LaravelTestCase
 *
 * Unit test class that extends the Laravel unit test class and implements some
 * Codeception support structures.
 *
 * @subpackage LaravelTestCase
 * @author     Dave Redfern
 */
class LaravelTestCase extends TestCase implements \Codeception\TestInterface
{

    use EnsureLaravelModuleDoctrineClosed;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * @var \Codeception\Test\Metadata
     */
    private $metadata;

    /**
     * @var \UnitTester
     */
    protected $tester;



    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Protect test setup
     */
    final protected function setUp()
    {
        parent::setUp();

        $this->setUpCodeception();

        $this->_before();
    }

    /**
     * @return \Codeception\Test\Metadata
     */
    public function getMetadata()
    {
        if (!$this->metadata) {
            $this->metadata = new \Codeception\Test\Metadata();
        }

        return $this->metadata;
    }

    /**
     * Sets up the necessary codeception stuff
     */
    protected function setUpCodeception()
    {
        if ($this->getMetadata()->isBlocked()) {
            if ($this->getMetadata()->getSkip() !== null) {
                $this->markTestSkipped($this->getMetadata()->getSkip());
            }
            if ($this->getMetadata()->getIncomplete() !== null) {
                $this->markTestIncomplete($this->getMetadata()->getIncomplete());
            }

            return;
        }
        $scenario   = new \Codeception\Scenario($this);
        $actorClass = $this->getMetadata()->getCurrent('actor');

        if ($actorClass) {
            $I               = new $actorClass($scenario);
            $property        = lcfirst(\Codeception\Configuration::config()['actor']);
            $this->$property = $I;
        }

        $this->getMetadata()->getService('di')->injectDependencies($this);
    }

    /**
     * Protect test tear down
     */
    final protected function tearDown()
    {
        $this->_after();

        /*
         * Close the Laravel5 module connections
         */
        $this->ensureDoctrineClosed();

        /*
         * Destroy ALL doctrine object managers
         */
        $registry = $this->app->make(DoctrineRegistry::class);

        $this->closeDoctrineRegistryConnections($registry);

        parent::tearDown();
    }

    /**
     * Override this method to perform custom setup operations
     */
    protected function _before()
    {

    }

    /**
     * Override this method to perform custom teardown operations
     */
    protected function _after()
    {

    }
}
