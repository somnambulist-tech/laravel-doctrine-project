<?php

/**
 * Class TestCase
 *
 * @subpackage TestCase
 * @author     Dave Redfern
 */
class TestCase extends \Codeception\Test\Unit
{

    use EnsureLaravelModuleDoctrineClosed;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Ensure Doctrine shutdown is always called
     */
    protected function tearDown()
    {
        $this->ensureDoctrineClosed();

        $this->_after();
    }
}
