<?php

/**
 * Class TestCase
 *
 * @subpackage TestCase
 * @author     Dave Redfern
 */
class TestCase extends Illuminate\Foundation\Testing\TestCase
{

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
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

        $this->customTestSetUp();
    }

    /**
     * Protect test tear down
     */
    final protected function tearDown()
    {
        parent::tearDown();

        $this->customTestTearDown();
    }

    /**
     * Override this method to perform custom setup operations
     */
    protected function customTestSetUp()
    {

    }

    /**
     * Override this method to perform custom teardown operations
     */
    protected function customTestTearDown()
    {

    }
}
